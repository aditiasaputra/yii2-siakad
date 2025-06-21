<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Region;

class RegionController extends Controller
{
    public function actionGetChildren($parentCode)
    {

        Yii::$app->response->format = Response::FORMAT_JSON;
        $data = Region::getList($parentCode);

        Yii::$app->response->statusCode = 200;

        return array_map(fn($item) => [
            'id' => $item['kode'],
            'text' => $item['nama']
        ], $data);
    }
}
