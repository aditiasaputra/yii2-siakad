<?php

namespace backend\controllers;

use common\models\Employee;
use common\models\User;
use Yii;
use backend\components\Controller;
use common\models\Student;
use yii\filters\VerbFilter;
use backend\models\StudentForm;
use backend\models\StudentSearch;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use backend\models\ChangePasswordForm;
use yii\web\UploadedFile;

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
        $changePasswordmodel = new ChangePasswordForm();

        return $this->render('show', [
            'model' => $this->findModel($id),
            'assetDir' => $assetDir,
            'changePasswordmodel' => $changePasswordmodel
        ]);
    }

    public function actionCreate()
    {
        $userModel = new User();
        $studentModel = new Student();

        if (Yii::$app->request->isPost) {
            $userPost = Yii::$app->request->post();

            $userModel->load($userPost);
            $studentModel->load($userPost);

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

                $studentModel->user_id = $userModel->id;

                if (!$studentModel->save()) {
                    throw new \Exception('Gagal menyimpan data Mahasiswa.');
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Mahasiswa berhasil ditambahkan.');
                return $this->redirect(['show', 'id' => $studentModel->id]);

            } catch (\Throwable $e) {
                $transaction->rollBack();

                if (!empty($filePath) && file_exists($filePath)) {
                    @unlink($filePath);
                }

                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('create', compact('userModel', 'studentModel'));
    }

    public function actionUpdate($id)
    {
        $studentModel = $this->findModel($id);
        $userModel = User::findOne($studentModel->user_id);

        if (!$studentModel || !$userModel) {
            throw new NotFoundHttpException('Data tidak ditemukan.');
        }

        $oldImage = $userModel->image;

        if (Yii::$app->request->isPost &&
            $userModel->load(Yii::$app->request->post()) &&
            $studentModel->load(Yii::$app->request->post())) {

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

                if (!$studentModel->save()) {
                    throw new \Exception('Gagal menyimpan data Mahasiswa.');
                }

                $transaction->commit();
                Yii::$app->session->setFlash('success', 'Mahasiswa berhasil diperbarui.');
                return $this->redirect(['show', 'id' => $studentModel->id]);

            } catch (\Throwable $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', compact('studentModel', 'userModel'));
    }

    public function actionDelete($id)
    {
        $student = $this->findModel($id);

        if (!$student) {
            Yii::$app->session->setFlash('error', 'Mahasiswa gagal dihapus.');
            throw new NotFoundHttpException('Mahasiswa tidak ditemukan.');
        }

        $user = $student->user ?? null;
        $imagePath = $user && $user->image && !str_starts_with($user->image, 'img/avatar')
            ? Yii::getAlias('@webroot/uploads/') . $user->image
            : null;

        $transaction = Yii::$app->db->beginTransaction();

        try {

            if (!$student->delete()) {
                throw new \Exception('Gagal menghapus data Mahasiswa.');
            }

            if ($user && !$user->delete()) {
                throw new \Exception('Gagal menghapus data Pengguna.');
            }

            if ($imagePath && file_exists($imagePath)) {
                @unlink($imagePath);
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Mahasiswa berhasil dihapus.');
        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Student::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Halaman yang diminta tidak ada.');
    }
}