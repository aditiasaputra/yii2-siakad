<?php

namespace backend\controllers;

use backend\models\CurriculumYear;
use backend\models\StudyProgram;
use backend\models\Subject;
use backend\models\SubjectGroup;
use backend\models\SubjectSearch;
use backend\models\SubjectType;
use common\models\Lecture;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class SubjectController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => ['class' => AccessControl::class, 'rules' => [['allow' => true, 'roles' => ['@']]]],
            'verbs' => ['class' => VerbFilter::class, 'actions' => ['delete' => ['POST'], 'upload-document' => ['POST'], 'delete-document' => ['POST']]],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new SubjectSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', array_merge(compact('searchModel', 'dataProvider'), $this->options()));
    }

    public function actionCreate()
    {
        $model = new Subject();
        if ($this->saveModel($model)) {
            Yii::$app->session->setFlash('success', 'Mata Kuliah berhasil ditambahkan.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', array_merge(compact('model'), $this->options()));
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($this->saveModel($model)) {
            Yii::$app->session->setFlash('success', 'Mata Kuliah berhasil diperbarui.');
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', array_merge(compact('model'), $this->options()));
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $syllabusFile = $model->syllabus_file;
        $materialDetailsFile = $model->material_details_file;
        if ($model->delete() !== false) {
            $this->removeDocumentFile($syllabusFile);
            $this->removeDocumentFile($materialDetailsFile);
        }
        Yii::$app->session->setFlash('success', 'Mata Kuliah berhasil dihapus.');
        return $this->redirect(['index']);
    }

    public function actionUploadDocument($id, $type)
    {
        $model = $this->findModel($id);
        [$uploadAttribute, $fileAttribute, $label] = $this->documentDefinition($type);
        $model->$uploadAttribute = UploadedFile::getInstance($model, $uploadAttribute);
        if (!$model->$uploadAttribute || !$model->validate([$uploadAttribute])) {
            Yii::$app->session->setFlash('error', $model->getFirstError($uploadAttribute) ?: "File {$label} wajib dipilih.");
            return $this->redirect(['view', 'id' => $id, 'tab' => $type]);
        }

        $directory = Yii::getAlias('@runtime/subject-documents');
        FileHelper::createDirectory($directory);
        $originalName = FileHelper::normalizePath($model->$uploadAttribute->baseName, '/');
        $originalName = preg_replace('/[^A-Za-z0-9._-]+/', '-', basename($originalName));
        $storedName = uniqid($type . '_', true) . '_' . $originalName . '.' . strtolower($model->$uploadAttribute->extension);
        if (!$model->$uploadAttribute->saveAs($directory . DIRECTORY_SEPARATOR . $storedName)) {
            Yii::$app->session->setFlash('error', "File {$label} gagal diunggah.");
            return $this->redirect(['view', 'id' => $id, 'tab' => $type]);
        }

        $oldFile = $model->$fileAttribute;
        $model->updateAttributes([$fileAttribute => $storedName]);
        $this->removeDocumentFile($oldFile);
        Yii::$app->session->setFlash('success', "File {$label} berhasil diunggah.");
        return $this->redirect(['view', 'id' => $id, 'tab' => $type]);
    }

    public function actionDownloadDocument($id, $type)
    {
        $model = $this->findModel($id);
        [, $fileAttribute] = $this->documentDefinition($type);
        $storedName = $model->$fileAttribute;
        $path = $this->documentPath($storedName);
        if (!$storedName || !$path || !is_file($path)) {
            throw new NotFoundHttpException('File dokumen tidak ditemukan.');
        }
        $downloadName = preg_replace('/^[^_]+_[^_]+_/', '', $storedName);
        return Yii::$app->response->sendFile($path, $downloadName, ['inline' => false]);
    }

    public function actionDeleteDocument($id, $type)
    {
        $model = $this->findModel($id);
        [, $fileAttribute, $label] = $this->documentDefinition($type);
        $this->removeDocumentFile($model->$fileAttribute);
        $model->updateAttributes([$fileAttribute => null]);
        Yii::$app->session->setFlash('success', "File {$label} berhasil dihapus.");
        return $this->redirect(['view', 'id' => $id, 'tab' => $type]);
    }

    private function documentDefinition($type): array
    {
        $definitions = [
            'syllabus' => ['syllabus_upload', 'syllabus_file', 'Silabus Mata Kuliah'],
            'material-details' => ['material_details_upload', 'material_details_file', 'Rincian Materi'],
        ];
        if (!isset($definitions[$type])) {
            throw new NotFoundHttpException('Jenis dokumen tidak ditemukan.');
        }
        return $definitions[$type];
    }

    private function documentPath($storedName): ?string
    {
        if (!$storedName || basename($storedName) !== $storedName) {
            return null;
        }
        return Yii::getAlias('@runtime/subject-documents') . DIRECTORY_SEPARATOR . $storedName;
    }

    private function removeDocumentFile($storedName): void
    {
        $path = $this->documentPath($storedName);
        if ($path && is_file($path)) {
            unlink($path);
        }
    }

    public function actionCopy()
    {
        $options = $this->options();
        if (!Yii::$app->request->isPost) {
            return $this->render('copy', $options);
        }

        $sourceProgramId = Yii::$app->request->post('source_study_program_id');
        $sourceYearId = Yii::$app->request->post('source_curriculum_year_id');
        $targetProgramId = Yii::$app->request->post('target_study_program_id');
        $targetYearId = Yii::$app->request->post('target_curriculum_year_id');
        if (!$sourceProgramId || !$sourceYearId || !$targetProgramId || !$targetYearId) {
            Yii::$app->session->setFlash('error', 'Prodi dan tahun kurikulum sumber serta tujuan wajib dipilih.');
            return $this->redirect(['copy']);
        }
        if ((string)$sourceProgramId === (string)$targetProgramId && (string)$sourceYearId === (string)$targetYearId) {
            Yii::$app->session->setFlash('error', 'Sumber dan tujuan salinan harus berbeda.');
            return $this->redirect(['copy']);
        }

        $sources = Subject::find()->where(['study_program_id' => $sourceProgramId, 'curriculum_year_id' => $sourceYearId])->all();
        if (!$sources) {
            Yii::$app->session->setFlash('warning', 'Tidak ada Mata Kuliah pada sumber yang dipilih.');
            return $this->redirect(['copy']);
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $copied = 0;
            $skipped = 0;
            foreach ($sources as $source) {
                if (Subject::find()->where(['curriculum_year_id' => $targetYearId, 'study_program_id' => $targetProgramId, 'code' => $source->code])->exists()) {
                    $skipped++;
                    continue;
                }
                $copy = new Subject($source->getAttributes([
                    'code', 'name', 'name_en', 'subject_type_id', 'subject_group_id', 'credits',
                    'face_to_face_credits', 'practicum_credits', 'lab_credits', 'ksk_credits', 'pbl_credits',
                    'mku', 'sap', 'syllabus', 'teaching_material', 'module',
                ]));
                $copy->curriculum_year_id = $targetYearId;
                $copy->study_program_id = $targetProgramId;
                if (!$copy->save()) {
                    throw new \RuntimeException(implode(' ', $copy->getFirstErrors()));
                }
                foreach ($source->getLecturers()->select('lectures.id')->column() as $lecturerId) {
                    Yii::$app->db->createCommand()->insert('subject_lecturers', ['subject_id' => $copy->id, 'lecturer_id' => $lecturerId])->execute();
                }
                $copied++;
            }
            $transaction->commit();
            Yii::$app->session->setFlash('success', "{$copied} Mata Kuliah berhasil disalin" . ($skipped ? "; {$skipped} dilewati karena sudah tersedia." : '.'));
            return $this->redirect(['index', 'SubjectSearch' => ['study_program_id' => $targetProgramId, 'curriculum_year_id' => $targetYearId]]);
        } catch (\Throwable $exception) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Salin Mata Kuliah gagal: ' . $exception->getMessage());
            return $this->redirect(['copy']);
        }
    }

    private function saveModel(Subject $model): bool
    {
        if (!Yii::$app->request->isPost || !$model->load(Yii::$app->request->post())) {
            return false;
        }
        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$model->save()) {
                $transaction->rollBack();
                return false;
            }
            Yii::$app->db->createCommand()->delete('subject_lecturers', ['subject_id' => $model->id])->execute();
            foreach (array_unique((array) $model->lecturer_ids) as $lecturerId) {
                Yii::$app->db->createCommand()->insert('subject_lecturers', ['subject_id' => $model->id, 'lecturer_id' => $lecturerId])->execute();
            }
            $transaction->commit();
            return true;
        } catch (\Throwable $exception) {
            $transaction->rollBack();
            throw $exception;
        }
    }

    private function options(): array
    {
        $lecturers = [];
        foreach (Lecture::find()->with('user')->all() as $lecture) {
            $lecturers[$lecture->id] = $lecture->user ? $lecture->user->name : 'Dosen #' . $lecture->id;
        }
        return [
            'curriculumYears' => ArrayHelper::map(CurriculumYear::find()->orderBy(['year' => SORT_DESC])->all(), 'id', 'year'),
            'subjectTypes' => ArrayHelper::map(SubjectType::find()->orderBy('name')->all(), 'id', 'name'),
            'subjectGroups' => ArrayHelper::map(SubjectGroup::find()->orderBy('name')->all(), 'id', 'name'),
            'studyPrograms' => ArrayHelper::map(StudyProgram::find()->orderBy('name')->all(), 'id', 'name'),
            'lecturers' => $lecturers,
        ];
    }

    protected function findModel($id)
    {
        if (($model = Subject::find()->with(['curriculumYear', 'subjectType', 'subjectGroup', 'studyProgram', 'lecturers.user'])->where(['subjects.id' => $id])->one()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Mata Kuliah tidak ditemukan.');
    }
}
