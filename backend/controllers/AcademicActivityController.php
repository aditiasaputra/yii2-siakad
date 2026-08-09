<?php
namespace backend\controllers;
use backend\models\AcademicActivity;
use backend\models\AcademicActivitySearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
class AcademicActivityController extends Controller
{
    public function behaviors() { return ['access' => ['class' => AccessControl::class, 'rules' => [['allow' => true, 'roles' => ['@']]]], 'verbs' => ['class' => VerbFilter::class, 'actions' => ['delete' => ['POST']]]]; }
    public function actionIndex() { $searchModel = new AcademicActivitySearch(); $dataProvider = $searchModel->search(Yii::$app->request->queryParams); return $this->render('index', compact('searchModel', 'dataProvider')); }
    public function actionCreate() { $model = new AcademicActivity(['background' => '#007bff']); if ($model->load(Yii::$app->request->post()) && $model->save()) { Yii::$app->session->setFlash('success', 'Kegiatan akademik berhasil ditambahkan.'); return $this->redirect(['view', 'id' => $model->id]); } return $this->render('create', compact('model')); }
    public function actionView($id) { $model = $this->findModel($id); return $this->render('view', compact('model')); }
    public function actionUpdate($id) { $model = $this->findModel($id); if ($model->load(Yii::$app->request->post()) && $model->save()) { Yii::$app->session->setFlash('success', 'Kegiatan akademik berhasil diperbarui.'); return $this->redirect(['view', 'id' => $model->id]); } return $this->render('update', compact('model')); }
    public function actionDelete($id) { $this->findModel($id)->delete(); Yii::$app->session->setFlash('success', 'Kegiatan akademik berhasil dihapus.'); return $this->redirect(['index']); }
    protected function findModel($id) { if (($model = AcademicActivity::findOne($id)) !== null) return $model; throw new NotFoundHttpException('Kegiatan akademik tidak ditemukan.'); }
}
