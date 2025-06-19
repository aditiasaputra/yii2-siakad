<?php

namespace backend\controllers;

use backend\models\EmployeeForm;
use backend\models\EmployeeSearch;
use common\models\Employee;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use backend\components\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
        $userModel = new User();
        $employeeModel = new Employee();

        if (Yii::$app->request->isPost && $userModel->load(Yii::$app->request->post()) && $employeeModel->load(Yii::$app->request->post())) {

            $uploadedFile = UploadedFile::getInstance($userModel, 'image');

            if ($uploadedFile) {
                $fileName = uniqid() . '.' . $uploadedFile->extension;
                $filePath = Yii::getAlias('@webroot/uploads/profiles/') . $fileName;

                if (!is_dir(dirname($filePath))) {
                    mkdir(dirname($filePath), 0775, true);
                }

                if ($uploadedFile->saveAs($filePath)) {
                    $userModel->image = 'profiles/' . $fileName;
                }
            } else {
                $userModel->image = 'img/avatar.png';
            }

            $userModel->generateAuthKey();
            $userModel->setPassword($userModel->password);

            if ($userModel->save()) {
                $employeeModel->user_id = $userModel->id;

                if ($employeeModel->save()) {
                    Yii::$app->session->setFlash('success', 'Pegawai berhasil ditambahkan.');
                    return $this->redirect(['show', 'id' => $employeeModel->id]);
                } else {
                    $userModel->delete();
                    Yii::$app->session->setFlash('error', 'Gagal menyimpan data pegawai.');
                }
            } else {
                Yii::$app->session->setFlash('error', 'Gagal menyimpan data user.');
            }
        }

        return $this->render('create', [
            'userModel' => $userModel,
            'employeeModel' => $employeeModel,
        ]);
    }


    public function actionUpdate($id)
    {
        $employee = $this->findModel($id);
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
        Yii::$app->session->setFlash('success', 'Pegawai berhasil dihapus.');

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