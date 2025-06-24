<?php

namespace backend\controllers;

use backend\models\ChangePasswordForm;
use backend\models\LectureSearch;
use backend\components\Controller;
use common\models\Employee;
use common\models\Lecture;
use common\models\User;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

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
        $lectureModel = new Lecture();

        if (Yii::$app->request->isPost) {
            $userModel->load(Yii::$app->request->post());
            $employeeModel->load(Yii::$app->request->post());
            $lectureModel->load(Yii::$app->request->post());

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

            $transaction = Yii::$app->db->beginTransaction();

            try {
                if (!$userModel->save()) {
                    throw new \Exception("Gagal menyimpan User.");
                }

                $employeeModel->user_id = $userModel->id;

                if (!$employeeModel->save()) {
                    throw new \Exception("Gagal menyimpan Employee.");
                }

                $lectureModel->employee_id = $employeeModel->id;

                if (!$lectureModel->save()) {
                    throw new \Exception("Gagal menyimpan Lecture.");
                }

                $transaction->commit();

                Yii::$app->session->setFlash('success', 'Dosen berhasil ditambahkan.');
                return $this->redirect(['show', 'id' => $lectureModel->id]);

            } catch (\Throwable $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Error Message: ' . $e->getMessage());
            }
        }

        return $this->render('create', [
            'userModel' => $userModel,
            'employeeModel' => $employeeModel,
            'lectureModel' => $lectureModel,
        ]);
    }

    public function actionUpdate($id)
    {
        $lectureModel = Lecture::findOne($id);

        if (!$lectureModel || !$lectureModel->employee) {
            throw new NotFoundHttpException("Data Dosen tidak ditemukan.");
        }

        $employeeModel = $lectureModel->employee;
        $userModel = $employeeModel->user;

        if (!$userModel) {
            throw new NotFoundHttpException("Data Pengguna tidak ditemukan.");
        }

        if (Yii::$app->request->isPost) {
            $userModel->load(Yii::$app->request->post());
            $employeeModel->load(Yii::$app->request->post());
            $lectureModel->load(Yii::$app->request->post());
            $oldImage = $userModel->image;

            $uploadedFile = UploadedFile::getInstance($userModel, 'image');

            if ($uploadedFile) {
                $uploadDir = Yii::getAlias('@webroot/uploads/profiles/');
                FileHelper::createDirectory($uploadDir);

                $fileName = uniqid('') . '.' . $uploadedFile->extension;

                if ($uploadedFile->saveAs($uploadDir . $fileName)) {
                    $userModel->image = 'profiles/' . $fileName;

                    if ($oldImage && !str_starts_with($oldImage, 'img/avatar')) {
                        $oldFile = Yii::getAlias('@webroot/uploads/') . $oldImage;
                        if (file_exists($oldFile)) {
                            @unlink($oldFile);
                        }
                    }
                }
            } else {
                $userModel->image = Yii::$app->request->post('User')['avatar'] ?? $oldImage;
            }

            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (!$userModel->save()) {
                    throw new \Exception("Gagal menyimpan Pengguna.");
                }

                if (!$employeeModel->save()) {
                    throw new \Exception("Gagal menyimpan Pegawai.");
                }

                if (!$lectureModel->save()) {
                    throw new \Exception("Gagal menyimpan Dosen.");
                }

                $transaction->commit();

                Yii::$app->session->setFlash('success', 'Dosen berhasil diperbarui.');
                return $this->redirect(['show', 'id' => $lectureModel->id]);

            } catch (\Throwable $e) {
                $transaction->rollBack();
                Yii::$app->session->setFlash('error', 'Error Message: ' . $e->getMessage());
            }
        }

        return $this->render('update', [
            'lectureModel' => $lectureModel,
            'employeeModel' => $employeeModel,
            'userModel' => $userModel,
        ]);
    }

    public function actionDelete($id)
    {
        $lecture = $this->findModel($id);

        if (!$lecture || !$lecture->employee || !$lecture->employee->user) {
            Yii::$app->session->setFlash('error', 'Data Dosen tidak ditemukan.');
            throw new NotFoundHttpException("Lecture not found.");
        }

        $employee = $lecture->employee;
        $user = $employee->user;

        $transaction = Yii::$app->db->beginTransaction();

        try {
            if (!$lecture->delete()) {
                throw new \Exception('Gagal menghapus data Dosen.');
            }

            if (!$employee->delete()) {
                throw new \Exception('Gagal menghapus data Pegawai.');
            }

            if (!$user->delete()) {
                throw new \Exception('Gagal menghapus data Pengguna.');
            }

            $transaction->commit();
            Yii::$app->session->setFlash('success', 'Dosen berhasil dihapus.');

        } catch (\Throwable $e) {
            $transaction->rollBack();
            Yii::$app->session->setFlash('error', 'Error Message: ' . $e->getMessage());
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Lecture::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Halaman yang diminta tidak ada.');
    }
}