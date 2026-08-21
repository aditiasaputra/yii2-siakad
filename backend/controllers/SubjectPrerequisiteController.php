<?php

namespace backend\controllers;

use backend\models\CurriculumYear;
use backend\models\StudyProgram;
use backend\models\StudyProgramCurriculum;
use backend\models\Subject;
use backend\models\SubjectPrerequisite;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SubjectPrerequisiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => ['class' => AccessControl::class, 'rules' => [['allow' => true, 'roles' => ['@']]]],
            'verbs' => ['class' => VerbFilter::class, 'actions' => ['delete' => ['POST'], 'delete-all' => ['POST'], 'copy' => ['POST']]],
        ];
    }

    public function actionIndex($study_program_id = null, $curriculum_year_id = null, $course_curriculum_id = null)
    {
        $studyPrograms = ArrayHelper::map(StudyProgram::find()->orderBy('name')->all(), 'id', 'name');
        $curriculumYears = ArrayHelper::map(CurriculumYear::find()->orderBy(['year' => SORT_DESC])->all(), 'id', 'year');
        $defaultEntry = StudyProgramCurriculum::find()->joinWith('curriculumYear')->orderBy(['curriculum_years.year' => SORT_DESC, 'study_program_id' => SORT_ASC])->one();
        $studyProgramId = $study_program_id ?: ($defaultEntry ? $defaultEntry->study_program_id : array_key_first($studyPrograms));
        $curriculumYearId = $curriculum_year_id ?: ($defaultEntry && (string)$defaultEntry->study_program_id === (string)$studyProgramId ? $defaultEntry->curriculum_year_id : array_key_first($curriculumYears));
        $curriculumOptions = $this->curriculumOptions($studyProgramId, $curriculumYearId);

        $model = new SubjectPrerequisite(['course_curriculum_id' => $course_curriculum_id, 'requirement_type' => 'passed']);
        $curriculumIds = StudyProgramCurriculum::find()->select('id')->where(['study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId])->column();
        $entries = SubjectPrerequisite::find()->with(['courseCurriculum.subject', 'prerequisiteCurriculum.subject'])
            ->where(['course_curriculum_id' => $curriculumIds])->all();
        usort($entries, static fn($a, $b) => strcmp($a->courseCurriculum->subject->code, $b->courseCurriculum->subject->code));

        return $this->render('index', compact('model', 'entries', 'studyPrograms', 'curriculumYears', 'curriculumOptions', 'studyProgramId', 'curriculumYearId'));
    }

    public function actionCreate()
    {
        $model = new SubjectPrerequisite();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Prasyarat Mata Kuliah berhasil ditambahkan.');
        } else {
            Yii::$app->session->setFlash('error', implode(' ', $model->getFirstErrors()));
        }
        $course = StudyProgramCurriculum::findOne($model->course_curriculum_id);
        return $this->redirect(['index', 'study_program_id' => $course ? $course->study_program_id : null, 'curriculum_year_id' => $course ? $course->curriculum_year_id : null, 'course_curriculum_id' => $model->course_curriculum_id]);
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $options = $this->curriculumOptions($model->courseCurriculum->study_program_id, $model->courseCurriculum->curriculum_year_id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Prasyarat Mata Kuliah berhasil diperbarui.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', ['model' => $model, 'curriculumOptions' => $options]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $course = $model->courseCurriculum;
        $model->delete();
        Yii::$app->session->setFlash('success', 'Prasyarat Mata Kuliah berhasil dihapus.');
        return $this->redirect(['index', 'study_program_id' => $course->study_program_id, 'curriculum_year_id' => $course->curriculum_year_id]);
    }

    public function actionDeleteAll($study_program_id, $curriculum_year_id)
    {
        $ids = StudyProgramCurriculum::find()->select('id')->where(['study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id])->column();
        $count = $ids ? SubjectPrerequisite::deleteAll(['course_curriculum_id' => $ids]) : 0;
        Yii::$app->session->setFlash('success', "{$count} prasyarat berhasil dihapus.");
        return $this->redirect(['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id]);
    }

    public function actionCopy($study_program_id, $curriculum_year_id, $target_curriculum_year_id = null)
    {
        $targetCurriculumYearId = $target_curriculum_year_id ?: Yii::$app->request->post('target_curriculum_year_id');
        if (!$targetCurriculumYearId) {
            return $this->copyResponse(false, 'error', 'Kurikulum tujuan wajib dipilih.', ['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id]);
        }
        if ((string)$curriculum_year_id === (string)$targetCurriculumYearId) {
            return $this->copyResponse(false, 'warning', 'Kurikulum sumber dan tujuan harus berbeda.', ['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id]);
        }
        $sourceIds = StudyProgramCurriculum::find()->select('id')->where(['study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id])->column();
        $sourceRows = SubjectPrerequisite::find()->with(['courseCurriculum.subject', 'prerequisiteCurriculum.subject'])->where(['course_curriculum_id' => $sourceIds])->all();
        if (!$sourceRows) {
            return $this->copyResponse(false, 'warning', 'Data prasyarat sumber tidak ditemukan.', ['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id]);
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $this->ensureTargetCurriculum($study_program_id, $curriculum_year_id, $targetCurriculumYearId);
            $targetEntries = StudyProgramCurriculum::find()->with('subject')->where(['study_program_id' => $study_program_id, 'curriculum_year_id' => $targetCurriculumYearId])->all();
            $targetByCode = [];
            $targetByName = [];
            foreach ($targetEntries as $entry) {
                $targetByCode[$entry->subject->code] = $entry->id;
                $targetByName[$entry->subject->name] = $entry->id;
            }
            $copied = 0;
            $skipped = 0;
            foreach ($sourceRows as $source) {
                $courseId = $targetByCode[$source->courseCurriculum->subject->code] ?? $targetByName[$source->courseCurriculum->subject->name] ?? null;
                $prerequisiteId = $targetByCode[$source->prerequisiteCurriculum->subject->code] ?? $targetByName[$source->prerequisiteCurriculum->subject->name] ?? null;
                if (!$courseId || !$prerequisiteId || SubjectPrerequisite::find()->where(['course_curriculum_id' => $courseId, 'prerequisite_curriculum_id' => $prerequisiteId])->exists()) {
                    $skipped++;
                    continue;
                }
                $copy = new SubjectPrerequisite(['course_curriculum_id' => $courseId, 'prerequisite_curriculum_id' => $prerequisiteId, 'requirement_type' => $source->requirement_type, 'minimum_grade' => $source->minimum_grade]);
                if (!$copy->save()) {
                    throw new \RuntimeException(implode(' ', $copy->getFirstErrors()));
                }
                $copied++;
            }
            $transaction->commit();
            $message = "{$copied} prasyarat berhasil disalin" . ($skipped ? "; {$skipped} dilewati karena pasangan Mata Kuliah tujuan belum tersedia atau sudah tersalin." : '.');
            return $this->copyResponse(true, $copied ? 'success' : 'warning', $message, ['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $targetCurriculumYearId]);
        } catch (\Throwable $exception) {
            $transaction->rollBack();
            return $this->copyResponse(false, 'error', 'Salin Prasyarat gagal: ' . $exception->getMessage(), ['index', 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id]);
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

    private function ensureTargetCurriculum($studyProgramId, $sourceYearId, $targetYearId): void
    {
        $sourceEntries = StudyProgramCurriculum::find()->with('subject')->where([
            'study_program_id' => $studyProgramId,
            'curriculum_year_id' => $sourceYearId,
        ])->all();
        foreach ($sourceEntries as $sourceEntry) {
            $sourceSubject = $sourceEntry->subject;
            $targetSubject = Subject::find()->where([
                'study_program_id' => $studyProgramId,
                'curriculum_year_id' => $targetYearId,
                'code' => $sourceSubject->code,
            ])->one();
            if (!$targetSubject) {
                $targetSubject = new Subject($sourceSubject->getAttributes([
                    'code', 'name', 'name_en', 'subject_type_id', 'subject_group_id', 'credits',
                    'face_to_face_credits', 'practicum_credits', 'lab_credits', 'ksk_credits', 'pbl_credits',
                    'mku', 'sap', 'syllabus', 'teaching_material', 'module',
                ]));
                $targetSubject->study_program_id = $studyProgramId;
                $targetSubject->curriculum_year_id = $targetYearId;
                if (!$targetSubject->save()) {
                    throw new \RuntimeException(implode(' ', $targetSubject->getFirstErrors()));
                }
                foreach ($sourceSubject->getLecturers()->select('lectures.id')->column() as $lecturerId) {
                    Yii::$app->db->createCommand()->insert('subject_lecturers', ['subject_id' => $targetSubject->id, 'lecturer_id' => $lecturerId])->execute();
                }
            }
            if (StudyProgramCurriculum::find()->where([
                'study_program_id' => $studyProgramId,
                'curriculum_year_id' => $targetYearId,
                'subject_id' => $targetSubject->id,
            ])->exists()) {
                continue;
            }
            $targetEntry = new StudyProgramCurriculum($sourceEntry->getAttributes([
                'semester', 'minimum_grade', 'is_mandatory', 'is_package', 'topic', 'basic_competencies', 'minimum_credits',
            ]));
            $targetEntry->study_program_id = $studyProgramId;
            $targetEntry->curriculum_year_id = $targetYearId;
            $targetEntry->subject_id = $targetSubject->id;
            if (!$targetEntry->save()) {
                throw new \RuntimeException(implode(' ', $targetEntry->getFirstErrors()));
            }
        }
    }

    private function curriculumOptions($studyProgramId, $curriculumYearId): array
    {
        return ArrayHelper::map(
            StudyProgramCurriculum::find()
                ->joinWith('subject')
                ->where([
                    'study_program_curricula.study_program_id' => $studyProgramId,
                    'study_program_curricula.curriculum_year_id' => $curriculumYearId,
                ])
                ->orderBy(['subjects.name' => SORT_ASC])
                ->all(),
            'id',
            static fn($model) => $model->subject->code . ' - ' . $model->subject->name
        );
    }

    protected function findModel($id)
    {
        if (($model = SubjectPrerequisite::find()->with(['courseCurriculum.studyProgram', 'courseCurriculum.curriculumYear', 'courseCurriculum.subject', 'prerequisiteCurriculum.subject'])->where(['subject_prerequisites.id' => $id])->one()) !== null) { return $model; }
        throw new NotFoundHttpException('Prasyarat Mata Kuliah tidak ditemukan.');
    }
}
