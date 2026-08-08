<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\filters\VerbFilter;
use yii\helpers\FileHelper;
use backend\models\University;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * UniversityController implements the CRUD actions for University model.
 */
class UniversityController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all University models.
     *
     * @return string
     */
    public function actionIndex(): string
    {
        $model = University::find()->one();
    
        // $facultiesCount = $model->getFaculties()->count();
        $facultiesCount = 0;
        $activeStudents = 0;
        $totalPrograms = 0;
        
        return $this->render('index', [
            'model' => $model,
            'facultiesCount' => $facultiesCount,
            'activeStudents' => $activeStudents,
            'totalPrograms' => $totalPrograms,
        ]);
    }

    /**
     * Edit university profile
     *
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate(): Response|string
    {
        $model = University::find()->one();
        $oldLogo = $model->logo;

        if ($model->load(Yii::$app->request->post())) {
            // Handle logo upload
            $logoFile = UploadedFile::getInstance($model, 'logo');
            if ($logoFile) {
                $uploadPath = Yii::getAlias('@backend/web/uploads/universities/');
                FileHelper::createDirectory($uploadPath);
                
                $fileName = time() . '_' . $logoFile->baseName . '.' . $logoFile->extension;
                $filePath = $uploadPath . $fileName;
                
                if ($logoFile->saveAs($filePath)) {
                    // Delete old logo
                    if ($oldLogo && file_exists($uploadPath . $oldLogo)) {
                        unlink($uploadPath . $oldLogo);
                    }
                    $model->logo = $fileName;
                }
            } else {
                $model->logo = $oldLogo; // Keep the old logo
            }

            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Profil universitas berhasil diperbarui.');
                return $this->redirect(['university/index']);
            } else {
                Yii::$app->session->setFlash('error', 'Gagal memperbarui profil universitas.');
            }
        }

        return $this->render('update', compact('model'));
    }

    /**
     * Handle logo upload
     *
     * @param University $model
     * @param string|null $oldLogo
     */
    protected function handleLogoUpload($model, $oldLogo = null): void
    {
        $logoFile = UploadedFile::getInstance($model, 'logo');
        
        if ($logoFile) {
            $uploadPath = Yii::getAlias('@webroot') . '/uploads/logos/';
            
            // Create directory if not exists
            if (!is_dir($uploadPath)) {
                FileHelper::createDirectory($uploadPath);
            }
            
            // Generate unique filename
            $filename = uniqid() . '_' . time() . '.' . $logoFile->extension;
            
            if ($logoFile->saveAs($uploadPath . $filename)) {
                // Delete old logo if exists
                if ($oldLogo && file_exists($uploadPath . $oldLogo)) {
                    unlink($uploadPath . $oldLogo);
                }
                
                $model->logo = $filename;
            }
        }
    }

    /**
     * Finds the University model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id ID
     * @return University the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id): University|null
    {
        if (($model = University::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}