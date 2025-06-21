<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use backend\components\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use backend\models\UserSearch;
use yii\web\NotFoundHttpException;
use backend\models\ChangePasswordForm;

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
        $changePasswordmodel = new ChangePasswordForm();

        return $this->render('show', [
            'model' => $this->findModel($id),
            'assetDir' => $assetDir,
            'changePasswordmodel' => $changePasswordmodel,
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $uploadedFile = UploadedFile::getInstance($model, 'image');

            $model->image = 'img/avatar.png';
            $uploaded = false;

            if ($uploadedFile) {
                $fileName = uniqid() . '.' . $uploadedFile->extension;
                $uploadDir = Yii::getAlias('@webroot/uploads/profiles/');
                FileHelper::createDirectory($uploadDir);
                $filePath = $uploadDir . $fileName;

                if ($uploadedFile->saveAs($filePath)) {
                    $model->image = 'profiles/' . $fileName;
                    $uploaded = true;
                }
            }

            $model->generateAuthKey();
            $model->setPassword($model->password);

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Pengguna berhasil ditambahkan.');
                return $this->redirect(['show', 'id' => $model->id]);
            } else {
                if ($uploaded) {
                    $fullPath = Yii::getAlias('@webroot/uploads/') . $model->image;
                    if (file_exists($fullPath)) {
                        @unlink($fullPath);
                    }
                }

                Yii::$app->session->setFlash('error', 'Pengguna gagal ditambahkan.');
            }
        }

        return $this->render('create', compact('model'));
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $oldImage = $model->image;

        if (Yii::$app->request->isPost && $model->load(Yii::$app->request->post())) {
            $uploadedFile = UploadedFile::getInstance($model, 'image');

            if ($uploadedFile) {
                $uploadDir = Yii::getAlias('@webroot/uploads/profiles/');
                FileHelper::createDirectory($uploadDir, 0775, true);

                $fileName = uniqid() . '.' . $uploadedFile->extension;
                $filePath = $uploadDir . $fileName;

                if ($uploadedFile->saveAs($filePath)) {
                    $model->image = 'profiles/' . $fileName;

                    if ($oldImage && !str_starts_with($oldImage, 'img/avatar')) {
                        $oldFile = Yii::getAlias('@webroot/uploads/') . $oldImage;
                        if (file_exists($oldFile)) {
                            @unlink($oldFile);
                        }
                    }
                }
            } else {
                $post = Yii::$app->request->post('User');
                $model->image = $post['avatar'] ?? $oldImage;
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
        $transaction = Yii::$app->db->beginTransaction();

        try {
            $user = $this->findModel($id);

            if ($user->employee && $user->employee->lecture) {
                if (!$user->employee->lecture->delete()) {
                    throw new \Exception('Gagal menghapus data Dosen.');
                }
            }

            if ($user->employee) {
                if (!$user->employee->delete()) {
                    throw new \Exception('Gagal menghapus data Pegawai.');
                }
            }

            if ($user->image && !str_starts_with($user->image, 'img/avatar')) {
                $imagePath = Yii::getAlias('@webroot/uploads/') . $user->image;
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }

            if (!$user->delete()) {
                throw new \Exception('Gagal menghapus data Pengguna.');
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Pengguna dan data terkait berhasil dihapus.');
        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Pengguna gagal dihapus: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Halaman yang diminta tidak ada.');
    }
}
