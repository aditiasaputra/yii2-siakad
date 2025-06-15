<?php

namespace backend\controllers;

use backend\models\StudentForm;
use common\models\Student;
use Yii;
use backend\models\StudentSearch;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StudentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new StudentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionShow($id)
    {
        $assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

        return $this->render('show', [
            'model' => $this->findModel($id),
            'assetDir' => $assetDir,
        ]);
    }

    public function actionCreate()
    {
        $form = new StudentForm();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            Yii::$app->session->setFlash('success', "Mahasiswa berhasil ditambahkan.");
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('success', "Mahasiswa gagal ditambahkan.");
        }

        return $this->render('create', [
            'formModel' => $form,
        ]);
    }

    public function actionDelete($id)
    {
        $lecture = $this->findModel($id);
        if (!$lecture) {
            throw new NotFoundHttpException("Lecture not found.");
        }

        $lecture->delete();
        Yii::$app->session->setFlash('success', 'Mahasiswa berhasil dihapus.');

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}