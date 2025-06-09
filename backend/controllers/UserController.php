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
        return $this->render('show', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post())) {

            $uploadedFile = UploadedFile::getInstance($model, 'image');

            if ($uploadedFile) {
                $uploadPath = Yii::getAlias('@web/profiles/');
                FileHelper::createDirectory($uploadPath);

                $fileName = uniqid() . '.' . $uploadedFile->extension;
                $uploadedFile->saveAs($uploadPath . $fileName);

                $model->image = $fileName;
            }

            if ($model->save()) {
                return $this->redirect(['show', 'id' => $model->id]);
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
                $uploadPath = Yii::getAlias('@web/profiles/');
                FileHelper::createDirectory($uploadPath);

                $fileName = uniqid() . '.' . $uploadedFile->extension;
                $uploadedFile->saveAs($uploadPath . $fileName);
                $model->image = $fileName;

                if ($oldImage && !str_starts_with($oldImage, 'img/avatar/')) {
                    @unlink($uploadPath . $oldImage);
                }
            } else {
                $model->image = Yii::$app->request->post('User')['image'] ?? $oldImage;
            }

            if ($model->save()) {
                return $this->redirect(['show', 'id' => $model->id]);
            }
        }

        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

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
