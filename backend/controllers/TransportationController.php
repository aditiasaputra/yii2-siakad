<?php
namespace backend\controllers;
use backend\models\Transportation; use backend\models\TransportationSearch; use Yii; use yii\filters\AccessControl; use yii\filters\VerbFilter; use yii\web\Controller; use yii\web\NotFoundHttpException;
class TransportationController extends Controller
{
    public function behaviors() { return ['access'=>['class'=>AccessControl::class,'rules'=>[['allow'=>true,'roles'=>['@']]]],'verbs'=>['class'=>VerbFilter::class,'actions'=>['delete'=>['POST']]]]; }
    public function actionIndex() { $searchModel=new TransportationSearch(); $dataProvider=$searchModel->search(Yii::$app->request->queryParams); return $this->render('index',compact('searchModel','dataProvider')); }
    public function actionCreate() { $model=new Transportation(); if($model->load(Yii::$app->request->post())&&$model->save()){Yii::$app->session->setFlash('success','Transportasi berhasil ditambahkan.');return $this->redirect(['view','id'=>$model->id]);} return $this->render('create',compact('model')); }
    public function actionView($id) { $model=$this->findModel($id); return $this->render('view',compact('model')); }
    public function actionUpdate($id) { $model=$this->findModel($id); if($model->load(Yii::$app->request->post())&&$model->save()){Yii::$app->session->setFlash('success','Transportasi berhasil diperbarui.');return $this->redirect(['view','id'=>$model->id]);} return $this->render('update',compact('model')); }
    public function actionDelete($id) { $this->findModel($id)->delete(); Yii::$app->session->setFlash('success','Transportasi berhasil dihapus.'); return $this->redirect(['index']); }
    protected function findModel($id) { if(($model=Transportation::findOne($id))!==null)return $model; throw new NotFoundHttpException('Transportasi tidak ditemukan.'); }
}
