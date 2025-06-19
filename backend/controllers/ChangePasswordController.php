<?php

namespace backend\controllers;

use Yii;
use yii\web\Response;
use backend\components\Controller;
use yii\filters\AccessControl;
use backend\models\ChangePasswordForm;

class ChangePasswordController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    ['allow' => true, 'roles' => ['@']],
                ],
            ],
        ];
    }

    public function actionValidate()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->changePassword()) {
                return [
                    'success' => true,
                    'message' => 'Password berhasil diubah.',
                ];
            }

            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Gagal menyimpan perubahan password.',
                'errors' => $model->getErrors(),
            ];
        }

        Yii::$app->response->statusCode = 422;
        return [
            'success' => false,
            'message' => 'Validasi gagal.',
            'errors' => $model->getErrors(),
        ];
    }
}
