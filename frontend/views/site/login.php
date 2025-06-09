<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Nested Row within Card Body -->
<div class="row">
    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
    <div class="col-lg-6">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'login-form',
                'options' => [
                    'class' => 'user',
                    'role' => 'form',
                    'autocomplete' => 'off'
                ],
                'fieldConfig' => [
                    'template' => "{input}\n{error}",
                    'options' => ['class' => 'form-group'],
                ],
            ]); ?>

            <?= $form->field($model, 'username')->textInput([
                'class' => 'form-control form-control-user',
                'placeholder' => 'Enter Email Address...'
            ]) ?>

            <?= $form->field($model, 'password')->passwordInput([
                'class' => 'form-control form-control-user',
                'placeholder' => 'Password'
            ]) ?>

            <div class="form-group">
                <?= $form->field($model, 'rememberMe', [
                    'template' => '<div class="form-check">{input}{label}{error}</div>',
                ])->checkbox([
                    'class' => 'form-check-input',
                    'id' => 'loginform-rememberme',
                    'label' => false // Supaya label manual dipakai
                ])->label('Remember Me', ['class' => 'form-check-label', 'for' => 'loginform-rememberme']) ?>
            </div>

            <?= Html::submitButton('Login', [
                'class' => 'btn btn-primary btn-user btn-block',
                'name' => 'login-button'
            ]) ?>

            <?php ActiveForm::end(); ?>

            <hr>
            <div class="text-center">
                <?= Html::a('Forgot Password?', ['site/request-password-reset'], ['class' => 'small']) ?>
            </div>
            <div class="text-center">
                <a class="small" href="<?= Url::to('signup') ?>">Create an Account!</a>
            </div>
        </div>
    </div>
</div>