<?php

namespace backend\controllers;

use backend\models\CurriculumYear;
use backend\models\StudyProgram;
use backend\models\Subject;
use backend\models\SubjectEquivalence;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class SubjectEquivalenceController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => ['class' => AccessControl::class, 'rules' => [['allow' => true, 'roles' => ['@']]]],
            'verbs' => ['class' => VerbFilter::class, 'actions' => ['delete' => ['POST'], 'delete-all' => ['POST']]],
        ];
    }

    public function actionIndex($study_program_id = null, $new_curriculum_year_id = null, $old_curriculum_year_id = null, $q = null)
    {
        $studyPrograms = ArrayHelper::map(StudyProgram::find()->orderBy('name')->all(), 'id', 'name');
        $curriculumYears = ArrayHelper::map(CurriculumYear::find()->orderBy(['year' => SORT_DESC])->all(), 'id', 'year');
        $studyProgramId = $study_program_id ?: array_key_first($studyPrograms);
        $yearIds = array_keys($curriculumYears);
        $newYearId = $new_curriculum_year_id ?: ($yearIds[0] ?? null);
        $oldYearId = $old_curriculum_year_id ?: ($yearIds[1] ?? $newYearId);

        $query = SubjectEquivalence::find()->with(['newSubject', 'oldSubject'])->where([
            'subject_equivalences.study_program_id' => $studyProgramId,
            'subject_equivalences.new_curriculum_year_id' => $newYearId,
            'subject_equivalences.old_curriculum_year_id' => $oldYearId,
        ]);
        if ($q !== null && trim($q) !== '') {
            $query->joinWith(['newSubject newSubject', 'oldSubject oldSubject'])->andWhere(['or',
                ['like', 'newSubject.code', trim($q)], ['like', 'newSubject.name', trim($q)],
                ['like', 'oldSubject.code', trim($q)], ['like', 'oldSubject.name', trim($q)],
            ]);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy('subject_equivalences.id'),
            'pagination' => ['pageSize' => 10, 'pageSizeLimit' => [5, 100]],
            'sort' => false,
        ]);
        return $this->render('index', [
            'dataProvider' => $dataProvider, 'studyPrograms' => $studyPrograms,
            'curriculumYears' => $curriculumYears, 'studyProgramId' => $studyProgramId, 'newYearId' => $newYearId,
            'oldYearId' => $oldYearId, 'q' => $q,
        ]);
    }

    public function actionCreate($study_program_id = null, $new_curriculum_year_id = null, $old_curriculum_year_id = null)
    {
        $model = new SubjectEquivalence();
        if (!$model->load(Yii::$app->request->post())) {
            [$study_program_id, $new_curriculum_year_id, $old_curriculum_year_id] = $this->defaultContext($study_program_id, $new_curriculum_year_id, $old_curriculum_year_id);
            $model->setAttributes(compact('study_program_id', 'new_curriculum_year_id', 'old_curriculum_year_id'));
        } elseif ($model->save()) {
            Yii::$app->session->setFlash('success', 'Ekivalensi Mata Kuliah berhasil ditambahkan.');
            return $this->redirect($this->redirectParams($model));
        }
        return $this->render('create', $this->formParams($model));
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Ekivalensi Mata Kuliah berhasil diperbarui.');
            return $this->redirect($this->redirectParams($model));
        }
        return $this->render('update', $this->formParams($model));
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $redirect = $this->redirectParams($model);
        $model->delete();
        if (Yii::$app->request->isAjax) {
            return $this->asJson(['success' => true, 'message' => 'Ekivalensi Mata Kuliah berhasil dihapus.']);
        }
        Yii::$app->session->setFlash('success', 'Ekivalensi Mata Kuliah berhasil dihapus.');
        return $this->redirect($redirect);
    }

    public function actionDeleteAll($study_program_id, $new_curriculum_year_id, $old_curriculum_year_id)
    {
        $count = SubjectEquivalence::deleteAll(compact('study_program_id', 'new_curriculum_year_id', 'old_curriculum_year_id'));
        if (Yii::$app->request->isAjax) {
            return $this->asJson(['success' => true, 'message' => "{$count} data ekivalensi berhasil dihapus."]);
        }
        Yii::$app->session->setFlash('success', "{$count} data ekivalensi berhasil dihapus.");
        return $this->redirect(['index'] + compact('study_program_id', 'new_curriculum_year_id', 'old_curriculum_year_id'));
    }

    private function formParams(SubjectEquivalence $model): array
    {
        return [
            'model' => $model,
            'newSubjects' => $this->subjectOptions($model->study_program_id, $model->new_curriculum_year_id),
            'oldSubjects' => $this->subjectOptions($model->study_program_id, $model->old_curriculum_year_id),
        ];
    }

    private function defaultContext($studyProgramId, $newYearId, $oldYearId): array
    {
        $studyProgramId = $studyProgramId ?: StudyProgram::find()->select('id')->orderBy('name')->scalar();
        $yearIds = CurriculumYear::find()->select('id')->orderBy(['year' => SORT_DESC])->column();
        return [$studyProgramId, $newYearId ?: ($yearIds[0] ?? null), $oldYearId ?: ($yearIds[1] ?? ($yearIds[0] ?? null))];
    }

    private function subjectOptions($studyProgramId, $curriculumYearId): array
    {
        return ArrayHelper::map(Subject::find()->where(['study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId])->orderBy('code')->all(), 'id', static fn($subject) => $subject->code . ' - ' . $subject->name);
    }

    private function redirectParams(SubjectEquivalence $model): array
    {
        return ['index', 'study_program_id' => $model->study_program_id, 'new_curriculum_year_id' => $model->new_curriculum_year_id, 'old_curriculum_year_id' => $model->old_curriculum_year_id];
    }

    protected function findModel($id)
    {
        if (($model = SubjectEquivalence::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Ekivalensi Mata Kuliah tidak ditemukan.');
    }
}
