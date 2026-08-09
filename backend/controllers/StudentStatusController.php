<?php

namespace backend\controllers;

use backend\models\StudentStatus;
use backend\models\StudentStatusSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class StudentStatusController extends Controller
{
    public function behaviors() { return ['access' => ['class' => AccessControl::class, 'rules' => [['allow' => true, 'roles' => ['@']]]], 'verbs' => ['class' => VerbFilter::class, 'actions' => ['delete' => ['POST']]]]; }
    public function actionIndex() { $searchModel = new StudentStatusSearch(); $dataProvider = $searchModel->search(Yii::$app->request->queryParams); return $this->render('index', compact('searchModel', 'dataProvider')); }
    public function actionCreate() { $model = new StudentStatus(); if ($model->load(Yii::$app->request->post()) && $model->save()) { Yii::$app->session->setFlash('success', 'Status mahasiswa berhasil ditambahkan.'); return $this->redirect(['view', 'id' => $model->id]); } return $this->render('create', compact('model')); }
    public function actionView($id) { $model = $this->findModel($id); return $this->render('view', compact('model')); }
    public function actionUpdate($id) { $model = $this->findModel($id); if ($model->load(Yii::$app->request->post()) && $model->save()) { Yii::$app->session->setFlash('success', 'Status mahasiswa berhasil diperbarui.'); return $this->redirect(['view', 'id' => $model->id]); } return $this->render('update', compact('model')); }
    public function actionDelete($id) { $this->findModel($id)->delete(); Yii::$app->session->setFlash('success', 'Status mahasiswa berhasil dihapus.'); return $this->redirect(['index']); }
    protected function findModel($id) { if (($model = StudentStatus::findOne($id)) !== null) return $model; throw new NotFoundHttpException('Status mahasiswa tidak ditemukan.'); }
}
