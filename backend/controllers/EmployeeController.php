<?php

namespace backend\controllers;

use backend\models\ChangePasswordForm;
use backend\models\EmployeeSearch;
use common\models\Employee;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use backend\components\Controller;
use yii\helpers\FileHelper;
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
        $changePasswordmodel = new ChangePasswordForm();

        return $this->render('show', [
            'model' => $this->findModel($id),
            'assetDir' => $assetDir,
            'changePasswordmodel' => $changePasswordmodel,
        ]);
    }

    public function actionCreate()
    {
        $userModel = new User();
        $employeeModel = new Employee();

        if (Yii::$app->request->isPost) {
            $userPost = Yii::$app->request->post();
            $userModel->load($userPost);
            $employeeModel->load($userPost);

            $uploadedFile = UploadedFile::getInstance($userModel, 'image');

            $transaction = Yii::$app->db->beginTransaction();

            try {
                if ($uploadedFile) {
                    $fileName = uniqid('profile_') . '.' . $uploadedFile->extension;
                    $uploadPath = Yii::getAlias('@webroot/uploads/profiles/');
                    $filePath = $uploadPath . $fileName;

                    if (!is_dir($uploadPath)) {
                        mkdir($uploadPath, 0775, true);
                    }

                    if (!$uploadedFile->saveAs($filePath)) {
                        throw new \Exception('Gagal mengupload gambar.');
                    }

                    $userModel->image = 'profiles/' . $fileName;
                } else {
                    $userModel->image = 'img/avatar.png';
                }

                $userModel->generateAuthKey();
                $userModel->setPassword($userModel->password);

                if (!$userModel->save()) {
                    throw new \Exception('Gagal menyimpan data Pengguna.');
                }

                $employeeModel->user_id = $userModel->id;

                if (!$employeeModel->save()) {
                    throw new \Exception('Gagal menyimpan data Pegawai.');
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Pegawai berhasil ditambahkan.');
                return $this->redirect(['show', 'id' => $employeeModel->id]);

            } catch (\Throwable $e) {
                $transaction->rollBack();

                if (!empty($filePath) && file_exists($filePath)) {
                    @unlink($filePath);
                }

                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', compact('userModel', 'employeeModel'));
    }


    public function actionUpdate($id)
    {
        $employeeModel = $this->findModel($id);
        $userModel = User::findOne($employeeModel->user_id);

        if (!$employeeModel || !$userModel) {
            throw new NotFoundHttpException('Data tidak ditemukan.');
        }

        $oldImage = $userModel->image;

        if (Yii::$app->request->isPost &&
            $userModel->load(Yii::$app->request->post()) &&
            $employeeModel->load(Yii::$app->request->post())) {

            $uploadedFile = UploadedFile::getInstance($userModel, 'image');

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if ($uploadedFile) {
                    $uploadDir = Yii::getAlias('@webroot/uploads/profiles/');
                    FileHelper::createDirectory($uploadDir);

                    $fileName = uniqid('profile_') . '.' . $uploadedFile->extension;
                    $filePath = $uploadDir . $fileName;

                    if (!$uploadedFile->saveAs($filePath)) {
                        throw new \Exception('Gagal mengunggah file gambar.');
                    }

                    $userModel->image = 'profiles/' . $fileName;

                    if ($oldImage && !str_starts_with($oldImage, 'img/avatar')) {
                        $oldFile = Yii::getAlias('@webroot/uploads/') . $oldImage;
                        if (file_exists($oldFile)) {
                            @unlink($oldFile);
                        }
                    }
                } else {
                    $userModel->image = Yii::$app->request->post('User')['avatar'] ?? $oldImage;
                }

                if (!$userModel->save()) {
                    throw new \Exception('Gagal menyimpan data Pengguna.');
                }

                if (!$employeeModel->save()) {
                    throw new \Exception('Gagal menyimpan data Pegawai.');
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Pegawai berhasil diperbarui.');
                return $this->redirect(['show', 'id' => $employeeModel->id]);

            } catch (\Throwable $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', compact('employeeModel', 'userModel'));
    }

    public function actionDelete($id)
    {
        $employee = $this->findModel($id);

        if (!$employee) {
            Yii::$app->session->setFlash('error', 'Pegawai gagal dihapus.');
            throw new NotFoundHttpException('Pegawai tidak ditemukan.');
        }

        $user = $employee->user ?? null;
        $imagePath = $user && $user->image && !str_starts_with($user->image, 'img/avatar')
            ? Yii::getAlias('@webroot/uploads/') . $user->image
            : null;

        $transaction = Yii::$app->db->beginTransaction();

        try {

            if (!$employee->delete()) {
                throw new \Exception('Gagal menghapus data Pegawai.');
            }

            if ($user && !$user->delete()) {
                throw new \Exception('Gagal menghapus data Pengguna.');
            }

            if ($imagePath && file_exists($imagePath)) {
                @unlink($imagePath);
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Pegawai berhasil dihapus.');
        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Employee::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Halaman yang diminta tidak ada.');
    }
}