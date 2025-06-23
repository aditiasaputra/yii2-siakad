<?php

namespace backend\controllers;

use backend\components\Controller;
use Yii;
use common\models\Religion;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

class ReligionController extends Controller
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
        $dataProvider = new ActiveDataProvider([
            'query' => Religion::find()->where(['deleted_at' => null]),
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                ],
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Religion();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_at = time();
            $model->created_by = Yii::$app->user->id;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data agama berhasil ditambahkan.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->updated_at = time();
            $model->updated_by = Yii::$app->user->id;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Data agama berhasil diperbarui.');
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleted_at = time();
        $model->deleted_by = Yii::$app->user->id;
        if ($model->save(false)) {
            Yii::$app->session->setFlash('success', 'Data agama berhasil dihapus.');
        } else {
            Yii::$app->session->setFlash('error', 'Gagal menghapus data agama.');
        }

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Religion::findOne(['id' => $id, 'deleted_at' => null])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Data agama tidak ditemukan.');
    }
}
