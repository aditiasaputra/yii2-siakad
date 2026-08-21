<?php

namespace backend\controllers;

use backend\models\TimeSlot;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class TimeSlotController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => ['class' => AccessControl::class, 'rules' => [['allow' => true, 'roles' => ['@']]]],
            'verbs' => ['class' => VerbFilter::class, 'actions' => ['delete' => ['POST']]],
        ];
    }

    public function actionIndex()
    {
        $groups = ['morning' => [], 'afternoon' => [], 'evening' => []];
        foreach (TimeSlot::find()->orderBy(['time' => SORT_ASC])->all() as $model) {
            $groups[$model->period][] = $model;
        }
        return $this->render('index', compact('groups'));
    }

    public function actionCreate()
    {
        $model = new TimeSlot();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Slot Waktu berhasil ditambahkan.');
            return $this->redirect(['index']);
        }
        return $this->render('create', compact('model'));
    }

    public function actionView($id)
    {
        return $this->render('view', ['model' => $this->findModel($id)]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->time = $model->formattedTime;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', 'Slot Waktu berhasil diperbarui.');
            return $this->redirect(['index']);
        }
        return $this->render('update', compact('model'));
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->setFlash('success', 'Slot Waktu berhasil dihapus.');
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = TimeSlot::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Slot Waktu tidak ditemukan.');
    }
}
