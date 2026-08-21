<?php

namespace backend\controllers;

use backend\models\CurriculumYear;
use backend\models\StudyProgram;
use backend\models\StudyProgramCurriculum;
use backend\models\Subject;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class StudyProgramCurriculumController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => ['class' => AccessControl::class, 'rules' => [['allow' => true, 'roles' => ['@']]]],
            'verbs' => ['class' => VerbFilter::class, 'actions' => ['delete' => ['POST'], 'copy' => ['POST']]],
        ];
    }

    public function actionIndex($study_program_id = null, $curriculum_year_id = null)
    {
        $studyPrograms = ArrayHelper::map(StudyProgram::find()->orderBy('name')->all(), 'id', 'name');
        $curriculumYears = ArrayHelper::map(CurriculumYear::find()->orderBy(['year' => SORT_DESC])->all(), 'id', 'year');
        $defaultEntry = StudyProgramCurriculum::find()->joinWith('curriculumYear')->orderBy(['curriculum_years.year' => SORT_DESC, 'study_program_id' => SORT_ASC])->one();
        $studyProgramId = $study_program_id ?: ($defaultEntry ? $defaultEntry->study_program_id : array_key_first($studyPrograms));
        $curriculumYearId = $curriculum_year_id ?: ($defaultEntry && (string)$defaultEntry->study_program_id === (string)$studyProgramId ? $defaultEntry->curriculum_year_id : array_key_first($curriculumYears));

        $model = new StudyProgramCurriculum([
            'study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId,
            'minimum_grade' => 'E', 'is_mandatory' => true, 'is_package' => false,
        ]);
        $subjects = $this->subjectOptions($studyProgramId, $curriculumYearId);
        $entries = StudyProgramCurriculum::find()->with('subject')
            ->where(['study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId])
            ->orderBy(['semester' => SORT_ASC, 'id' => SORT_ASC])->all();
        $bySemester = [];
        foreach ($entries as $entry) {
            $bySemester[$entry->semester][] = $entry;
        }
        return $this->render('index', compact('model', 'studyPrograms', 'curriculumYears', 'subjects', 'bySemester', 'studyProgramId', 'curriculumYearId'));
    }

    public function actionCreate()
    {
        $model = new StudyProgramCurriculum();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Mata kuliah berhasil ditambahkan ke Kurikulum Prodi.');
        } else {
            Yii::$app->session->setFlash('error', implode(' ', $model->getFirstErrors()));
        }
        return $this->redirect(['index', 'study_program_id' => $model->study_program_id, 'curriculum_year_id' => $model->curriculum_year_id]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Data Kurikulum Prodi berhasil diperbarui.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
            'subjects' => $this->subjectOptions($model->study_program_id, $model->curriculum_year_id),
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $params = ['index', 'study_program_id' => $model->study_program_id, 'curriculum_year_id' => $model->curriculum_year_id];
        $model->delete();
        Yii::$app->session->setFlash('success', 'Data Kurikulum Prodi berhasil dihapus.');
        return $this->redirect($params);
    }

    public function actionCopy($study_program_id, $curriculum_year_id, $target_curriculum_year_id = null)
    {
        $targetCurriculumYearId = $target_curriculum_year_id ?: Yii::$app->request->post('target_curriculum_year_id');
        if (!$targetCurriculumYearId) {
            return $this->copyResponse(false, 'error', 'Kurikulum tujuan wajib dipilih.', ['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id]);
        }
        if ((string)$curriculum_year_id === (string)$targetCurriculumYearId) {
            return $this->copyResponse(false, 'error', 'Kurikulum sumber dan tujuan harus berbeda.', ['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id]);
        }

        $sourceEntries = StudyProgramCurriculum::find()->with('subject')->where(['study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id])->all();
        if (!$sourceEntries) {
            return $this->copyResponse(false, 'warning', 'Data Kurikulum Prodi sumber tidak ditemukan.', ['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id]);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $subjectResult = $this->ensureTargetSubjects($sourceEntries, $study_program_id, $targetCurriculumYearId);
            $targetSubjects = Subject::find()->where(['study_program_id' => $study_program_id, 'curriculum_year_id' => $targetCurriculumYearId])->all();
            $targetByCode = ArrayHelper::index($targetSubjects, 'code');
            $targetByName = ArrayHelper::index($targetSubjects, 'name');
            $copied = 0;
            $skipped = 0;
            foreach ($sourceEntries as $source) {
                $targetSubject = $targetByCode[$source->subject->code] ?? $targetByName[$source->subject->name] ?? null;
                if (!$targetSubject || StudyProgramCurriculum::find()->where(['study_program_id' => $study_program_id, 'curriculum_year_id' => $targetCurriculumYearId, 'subject_id' => $targetSubject->id])->exists()) {
                    $skipped++;
                    continue;
                }
                $copy = new StudyProgramCurriculum($source->getAttributes(['semester', 'minimum_grade', 'is_mandatory', 'is_package', 'topic', 'basic_competencies', 'minimum_credits']));
                $copy->study_program_id = $study_program_id;
                $copy->curriculum_year_id = $targetCurriculumYearId;
                $copy->subject_id = $targetSubject->id;
                if (!$copy->save()) {
                    throw new \RuntimeException(implode(' ', $copy->getFirstErrors()));
                }
                $copied++;
            }
            $transaction->commit();
            $message = "{$copied} data Kurikulum Prodi dan {$subjectResult['copied']} Mata Kuliah berhasil disalin" . ($skipped ? "; {$skipped} data sudah tersedia dan dilewati." : '.');
            return $this->copyResponse(true, $copied ? 'success' : 'warning', $message, ['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $targetCurriculumYearId]);
        } catch (\Throwable $exception) {
            $transaction->rollBack();
            return $this->copyResponse(false, 'error', 'Salin Kurikulum Prodi gagal: ' . $exception->getMessage(), ['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id]);
        }
    }

    private function copyResponse(bool $success, string $flashType, string $message, array $redirect)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['success' => $success, 'message' => $message, 'redirectUrl' => Url::to($redirect)];
        }
        Yii::$app->session->setFlash($flashType, $message);
        return $this->redirect($redirect);
    }

    private function ensureTargetSubjects(array $sourceEntries, $studyProgramId, $targetCurriculumYearId): array
    {
        $copied = 0;
        $skipped = 0;
        foreach ($sourceEntries as $entry) {
            $source = $entry->subject;
            if (Subject::find()->where(['study_program_id' => $studyProgramId, 'curriculum_year_id' => $targetCurriculumYearId, 'code' => $source->code])->exists()) {
                $skipped++;
                continue;
            }
            $copy = new Subject($source->getAttributes([
                'code', 'name', 'name_en', 'subject_type_id', 'subject_group_id', 'credits',
                'face_to_face_credits', 'practicum_credits', 'lab_credits', 'ksk_credits', 'pbl_credits',
                'mku', 'sap', 'syllabus', 'teaching_material', 'module',
            ]));
            $copy->study_program_id = $studyProgramId;
            $copy->curriculum_year_id = $targetCurriculumYearId;
            if (!$copy->save()) {
                throw new \RuntimeException(implode(' ', $copy->getFirstErrors()));
            }
            foreach ($source->getLecturers()->select('lectures.id')->column() as $lecturerId) {
                Yii::$app->db->createCommand()->insert('subject_lecturers', ['subject_id' => $copy->id, 'lecturer_id' => $lecturerId])->execute();
            }
            $copied++;
        }
        return compact('copied', 'skipped');
    }

    public function actionPrintSyllabus($study_program_id, $curriculum_year_id)
    {
        $studyProgram = StudyProgram::findOne($study_program_id);
        $curriculumYear = CurriculumYear::findOne($curriculum_year_id);
        if (!$studyProgram || !$curriculumYear) {
            throw new NotFoundHttpException('Program studi atau tahun kurikulum tidak ditemukan.');
        }
        $entries = StudyProgramCurriculum::find()->with(['subject.subjectType', 'subject.subjectGroup'])
            ->where(['study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id])
            ->orderBy(['semester' => SORT_ASC, 'id' => SORT_ASC])->all();
        Yii::$app->response->format = Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_UTF8,
            'format' => Pdf::FORMAT_A4,
            'orientation' => Pdf::ORIENT_PORTRAIT,
            'defaultFontSize' => 7,
            'defaultFont' => 'times',
            'marginLeft' => 9,
            'marginRight' => 9,
            'marginTop' => 10,
            'marginBottom' => 9,
            'marginHeader' => 5,
            'marginFooter' => 5,
            'destination' => Pdf::DEST_BROWSER,
            'filename' => 'Silabus-' . $studyProgram->code . '-' . $curriculumYear->year . '.pdf',
            'content' => $this->renderPartial('_syllabus_pdf', compact('studyProgram', 'curriculumYear', 'entries')),
            'cssFile' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css',
            'cssInline' => 'body,table,th,td,h1,h2,h3,h4,h5,h6{font-family:"Times New Roman",Times,serif}body{font-size:7pt}.report-title{text-align:center;margin:8px 0 12px;padding:4px 0}.report-title h2{font-size:12pt;margin:0 0 3px}.report-title h3{font-size:9pt;margin:0}.semester-layout,.semester-layout>tbody>tr>td{border:0 none!important}.semester-table{font-size:7pt;border:0.8px solid #000!important;border-collapse:collapse;page-break-inside:avoid}.semester-table th,.semester-table td{padding:1px 2px;border:0.8px solid #000!important;line-height:1}.semester-table th{background:#fff;color:#000;text-align:left;font-weight:normal}.semester-table .period-heading{background:#b7e1a1!important;text-align:center;font-size:8pt;font-weight:bold;text-decoration:none;padding:1px}.semester-table .semester-heading{background:#f2f2f2!important;text-align:center;font-size:8pt;font-weight:normal;padding:1px}.semester-gap{height:14px;line-height:14px;font-size:1px}',
            'options' => ['title' => 'Silabus ' . $studyProgram->name . ' ' . $curriculumYear->year],
            'methods' => ['SetHeader' => [$studyProgram->name . '||Kurikulum ' . $curriculumYear->year], 'SetFooter' => ['Dicetak ' . date('d-m-Y H:i') . '||Halaman {PAGENO} dari {nbpg}']],
        ]);
        return $pdf->render();
    }

    private function subjectOptions($studyProgramId, $curriculumYearId): array
    {
        return ArrayHelper::map(Subject::find()->where(['study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId])->orderBy('name')->all(), 'id', static fn($model) => $model->code . ' - ' . $model->name);
    }

    protected function findModel($id)
    {
        if (($model = StudyProgramCurriculum::find()->with(['studyProgram', 'curriculumYear', 'subject'])->where(['study_program_curricula.id' => $id])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Data Kurikulum Prodi tidak ditemukan.');
    }
}
