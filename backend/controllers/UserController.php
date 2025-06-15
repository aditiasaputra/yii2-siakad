<?php

namespace backend\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use common\models\User;
use backend\models\UserSearch;
use yii\web\UploadedFile;

class UserController extends Controller
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
        $searchModel = new UserSearch();
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
        $model = new User();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {

            $uploadedFile = UploadedFile::getInstance($model, 'image');

            if ($uploadedFile) {
                $fileName = uniqid() . '.' . $uploadedFile->extension;
                $filePath = Yii::getAlias('@webroot/uploads/profiles/') . $fileName;

                if (!is_dir(dirname($filePath))) {
                    mkdir(dirname($filePath), 0775, true);
                }

                if ($uploadedFile->saveAs($filePath)) {
                    $model->image = 'profiles/' . $fileName;
                }
            } else {
                $model->image = 'img/avatar.png';
            }

            $model->generateAuthKey();
            $model->setPassword($model->password);

            if ($model->save()) {
                Yii::$app->session->setFlash('success', "Pengguna berhasil ditambahkan.");
                return $this->redirect(['show', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', "Pengguna gagal ditambahkan.");
            }
        }

        return $this->render('create', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImage = $model->image;

        if ($model->load(Yii::$app->request->post())) {

            $uploadedFile = UploadedFile::getInstance($model, 'image');

            if ($uploadedFile) {
                $uploadDir = Yii::getAlias('@webroot/uploads/profiles/');
                FileHelper::createDirectory($uploadDir);

                $fileName = uniqid('') . '.' . $uploadedFile->extension;

                if ($uploadedFile->saveAs($uploadDir . $fileName)) {
                    $model->image = 'profiles/' . $fileName;

                    if ($oldImage && !str_starts_with($oldImage, 'img/avatar')) {
                        $oldFile = Yii::getAlias('@webroot/uploads/') . $oldImage;
                        if (file_exists($oldFile)) {
                            @unlink($oldFile);
                        }
                    }
                }
            } else {
                $model->image = Yii::$app->request->post('User')['avatar'] ?? $oldImage;
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Pengguna berhasil diperbaharui.');
                return $this->redirect(['show', 'id' => $model->id]);
            } else {
                Yii::$app->session->setFlash('error', 'Pengguna gagal diperbaharui.');
            }
        }

        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Pengguna berhasil dihapus.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
