<?php
namespace backend\controllers;
use Yii; use backend\models\UniversityEducationLevel; use backend\models\UniversityEducationLevelSearch; use yii\filters\AccessControl; use yii\filters\VerbFilter; use yii\web\Controller; use yii\web\NotFoundHttpException;
class UniversityEducationLevelController extends Controller
{
    public function behaviors() { return ['access' => ['class' => AccessControl::class, 'rules' => [['allow' => true, 'roles' => ['@']]]], 'verbs' => ['class' => VerbFilter::class, 'actions' => ['delete' => ['POST']]]]; }
    public function actionIndex() { $searchModel = new UniversityEducationLevelSearch(); return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $searchModel->search(Yii::$app->request->queryParams)]); }
    public function actionCreate() { $model = new UniversityEducationLevel(); if ($model->load(Yii::$app->request->post()) && $model->save()) { Yii::$app->session->setFlash('success', 'Tingkat pendidikan universitas berhasil ditambahkan.'); return $this->redirect(['view', 'id' => $model->id]); } return $this->render('create', compact('model')); }
    public function actionView($id) { return $this->render('view', ['model' => $this->findModel($id)]); }
    public function actionUpdate($id) { $model = $this->findModel($id); if ($model->load(Yii::$app->request->post()) && $model->save()) { Yii::$app->session->setFlash('success', 'Tingkat pendidikan universitas berhasil diperbarui.'); return $this->redirect(['view', 'id' => $model->id]); } return $this->render('update', compact('model')); }
    public function actionDelete($id) { $this->findModel($id)->delete(); Yii::$app->session->setFlash('success', 'Tingkat pendidikan universitas berhasil dihapus.'); return $this->redirect(['index']); }
    protected function findModel($id) { if (($model = UniversityEducationLevel::findOne($id)) !== null) return $model; throw new NotFoundHttpException('Data tidak ditemukan.'); }
}
