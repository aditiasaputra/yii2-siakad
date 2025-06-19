<?php

namespace backend\components;

use Yii;
use yii\web\Controller as BaseController;

class Controller extends BaseController
{
    public function beforeAction($action)
    {
        $freeAccess = [
            'site/login',
            'site/error',
        ];

        $route = Yii::$app->controller->id . '/' . $action->id;

        if (in_array($route, $freeAccess)) {
            return parent::beforeAction($action);
        }

        if (Yii::$app->user->isGuest) {
            Yii::$app->user->loginRequired();
            return false;
        }

        return parent::beforeAction($action);
    }
}
