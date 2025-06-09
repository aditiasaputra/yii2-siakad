<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\PasswordResetRequestForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Request password reset';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
    <div class="col-lg-6">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4"><?= Html::encode($this->title) ?></h1>
                <p class="mb-4">Enter your email to reset your password.</p>
            </div>

            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

            <div class="form-group">
                <?= $form->field($model, 'email')->textInput([
                    'autofocus' => true,
                    'class' => 'form-control form-control-user',
                    'placeholder' => 'Enter Email Address...'
                ])->label(false) ?>
            </div>

            <div class="form-group">
                <?= Html::submitButton('Send Reset Link', ['class' => 'btn btn-primary btn-user btn-block']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <hr>

            <div class="text-center">
                <?= Html::a('Create an Account!', ['site/signup'], ['class' => 'small']) ?>
            </div>
            <div class="text-center">
                <?= Html::a('Already have an account? Login!', ['site/login'], ['class' => 'small']) ?>
            </div>
        </div>
    </div>
</div>