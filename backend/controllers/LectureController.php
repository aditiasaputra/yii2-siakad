<?php

namespace backend\controllers;

use backend\models\LectureForm;
use backend\models\LectureSearch;
use backend\components\Controller;
use common\models\Lecture;
use Yii;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class LectureController extends Controller
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
        $searchModel = new LectureSearch();
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
        $form = new LectureForm();

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            Yii::$app->session->setFlash('success', "Dosen berhasil ditambahkan.");
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('success', "Dosen gagal ditambahkan.");
        }

        return $this->render('create', [
            'formModel' => $form,
        ]);
    }

    public function actionUpdate($id)
    {
        $lecture = Lecture::findOne($id);
        if (!$lecture) {
            throw new NotFoundHttpException("Lecture not found.");
        }

        $form = new LectureForm($lecture);

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            return $this->redirect(['view', 'id' => $lecture->id]);
        }

        return $this->render('update', [
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
        Yii::$app->session->setFlash('success', 'Dosen berhasil dihapus.');

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Lecture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}