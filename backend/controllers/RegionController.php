<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Region;

class RegionController extends Controller
{
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
}
