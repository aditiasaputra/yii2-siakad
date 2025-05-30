<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;

class SiswaController extends Controller
{
    public function actionIndex()
    {
        $message = 'Hello world';
        return $this->render("index", compact('message'));
    }
}