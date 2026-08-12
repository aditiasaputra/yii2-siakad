<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Region;
use backend\models\RegionSearch;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\db\IntegrityException;

class RegionController extends Controller
{
    private const MANAGED_LEVELS = ['province', 'regency', 'district'];

    public function behaviors()
    {
        return [
            'access' => ['class' => AccessControl::class, 'rules' => [['allow' => true, 'roles' => ['@']]]],
            'verbs' => ['class' => VerbFilter::class, 'actions' => ['delete' => ['POST']]],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGrid(string $level)
    {
        $level = $this->normalizeLevel($level);
        $searchModel = new RegionSearch(['searchLevel' => $level]);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->renderAjax('_grid', compact('searchModel', 'dataProvider', 'level'));
    }

    public function actionCreate(string $level = 'province')
    {
        $level = $this->normalizeLevel($level);
        $model = new Region(['level' => $level]);
        if ($level === 'province') {
            $model->kode = Region::generateNextCode($level);
        }
        if ($model->load(Yii::$app->request->post())) {
            $model->level = $level;
            if ($level === 'province') {
                $model->parent_kode = null;
            }
            try {
                $model->kode = Region::generateNextCode($level, $model->parent_kode);
            } catch (\InvalidArgumentException | \OverflowException $exception) {
                $model->addError('parent_kode', $exception->getMessage());
                return $this->render('create', compact('model', 'level'));
            }
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Region::levelLabels()[$level] . ' berhasil ditambahkan.');
                return $this->redirect(['view', 'kode' => $model->kode]);
            }
        }
        return $this->render('create', compact('model', 'level'));
    }

    public function actionView(string $kode)
    {
        return $this->render('view', ['model' => $this->findModel($kode)]);
    }

    public function actionUpdate(string $kode)
    {
        $model = $this->findModel($kode);
        $level = $this->normalizeLevel($model->level);
        $originalCode = $model->kode;
        $originalParentCode = $model->parent_kode;
        if ($model->load(Yii::$app->request->post())) {
            $model->level = $level;
            $model->kode = $originalCode;
            $model->parent_kode = $originalParentCode;
            if ($model->save()) {
                Yii::$app->session->setFlash('success', Region::levelLabels()[$level] . ' berhasil diperbarui.');
                return $this->redirect(['view', 'kode' => $model->kode]);
            }
        }
        return $this->render('update', compact('model', 'level'));
    }

    public function actionDelete(string $kode)
    {
        $model = $this->findModel($kode);
        $level = $model->level;
        try {
            $model->delete();
            Yii::$app->session->setFlash('success', 'Wilayah berhasil dihapus.');
        } catch (IntegrityException $exception) {
            Yii::$app->session->setFlash('error', 'Wilayah tidak dapat dihapus karena masih memiliki wilayah turunan atau digunakan data lain.');
        }
        return $this->redirect(['index', '#' => $level]);
    }

    public function actionRegency()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $parents = Yii::$app->request->post('depdrop_parents');

        if ($parents !== null && isset($parents[0])) {
            $provinceKode = $parents[0];
            $out = Region::find()
                ->select(['id' => 'kode', 'name'])
                ->where(['parent_kode' => $provinceKode, 'level' => 'regency'])
                ->asArray()
                ->all();

            return ['output' => $out, 'selected' => ''];
        }
        return ['output' => [], 'selected' => ''];
    }

    public function actionDistrict()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $parents = Yii::$app->request->post('depdrop_parents');

        if ($parents !== null && count($parents) >= 2) {
            $regencyKode = $parents[1];
            $out = Region::find()
                ->select(['id' => 'kode', 'name'])
                ->where(['parent_kode' => $regencyKode, 'level' => 'district'])
                ->asArray()
                ->all();

            return ['output' => $out, 'selected' => ''];
        }
        return ['output' => [], 'selected' => ''];
    }

    public function actionVillage()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $parents = Yii::$app->request->post('depdrop_parents');

        if ($parents !== null && count($parents) >= 3) {
            $districtKode = $parents[2];
            $out = Region::find()
                ->select(['id' => 'kode', 'name'])
                ->where(['parent_kode' => $districtKode, 'level' => 'village'])
                ->asArray()
                ->all();

            return ['output' => $out, 'selected' => ''];
        }
        return ['output' => [], 'selected' => ''];
    }

    private function normalizeLevel(string $level): string
    {
        if (!in_array($level, self::MANAGED_LEVELS, true)) {
            throw new NotFoundHttpException('Tingkat wilayah tidak ditemukan.');
        }
        return $level;
    }

    private function findModel(string $kode): Region
    {
        if (($model = Region::findOne(['kode' => $kode])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('Wilayah tidak ditemukan.');
    }
}
