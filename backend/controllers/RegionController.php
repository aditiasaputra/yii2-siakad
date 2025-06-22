<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use common\models\Region;
use yii\filters\VerbFilter;

class RegionController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'list' => ['POST'], // hanya menerima POST
                ],
            ],
        ];
    }

    /**
     * Action untuk AJAX request region (provinsi, kabupaten, dst)
     *
     * @return array JSON
     */
    public function actionList()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $parentKode = Yii::$app->request->post('parent_kode');
        $level = Yii::$app->request->post('level');

        if (!$level) {
            return ['success' => false, 'message' => 'Parameter level tidak ditemukan'];
        }

        $data = Region::getList($parentKode, $level);

        return [
            'success' => true,
            'items' => $data,
        ];
    }
}
