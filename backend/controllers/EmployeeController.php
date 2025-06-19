<?php

namespace backend\controllers;

use backend\models\EmployeeForm;
use backend\models\EmployeeSearch;
use common\models\Employee;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class EmployeeController extends Controller
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
        $searchModel = new EmployeeSearch();
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
        $model = new EmployeeForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', "Karyawan berhasil ditambahkan.");
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('success', "Karyawan gagal ditambahkan.");
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $employee = Employee::findOne($id);
        if (!$employee) {
            throw new NotFoundHttpException("Employee not found.");
        }

        $form = new EmployeeForm($employee);

        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            return $this->redirect(['view', 'id' => $employee->id]);
        }

        return $this->render('update', [
            'formModel' => $form,
        ]);
    }

    public function actionDelete($id)
    {
        $employee = $this->findModel($id);
        if (!$employee) {
            throw new NotFoundHttpException("Employee not found.");
        }

        $employee->delete();
        Yii::$app->session->setFlash('success', 'Karyawan berhasil dihapus.');

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}