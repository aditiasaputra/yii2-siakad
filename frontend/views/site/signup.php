<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\SignupForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;

$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- Nested Row within Card Body -->
<div class="row">
    <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
    <div class="col-lg-7">
        <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
            </div>

            <?php $form = ActiveForm::begin([
                'id' => 'form-signup',
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

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <?= $form->field($model, 'name')->textInput([
                        'class' => 'form-control form-control-user',
                        'autofocus' => true,
                        'placeholder' => 'Name'
                    ]) ?>
                </div>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <?= $form->field($model, 'username')->textInput([
                        'class' => 'form-control form-control-user',
                        'placeholder' => 'Username'
                    ]) ?>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-12 mb-3 mb-sm-0">
                    <?= $form->field($model, 'email')->textInput([
                        'class' => 'form-control form-control-user',
                        'placeholder' => 'Email Address'
                    ]) ?>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <?= $form->field($model, 'password')->passwordInput([
                        'class' => 'form-control form-control-user',
                        'placeholder' => 'Password'
                    ]) ?>
                </div>
                <div class="col-sm-6">
                    <?= $form->field($model, 'password_repeat')->passwordInput([
                        'class' => 'form-control form-control-user',
                        'placeholder' => 'Repeat Password'
                    ]) ?>
                </div>
            </div>

            <?= Html::submitButton('Register Account', [
                'class' => 'btn btn-primary btn-user btn-block'
            ]) ?>

            <?php ActiveForm::end(); ?>

            <hr>

            <hr>
            <div class="text-center">
                <?= Html::a('Forgot Password?', ['site/request-password-reset'], ['class' => 'small']) ?>
            </div>
            <div class="text-center">
                <a class="small" href="<?= Url::to('login') ?>">Already have an account? Login!</a>
            </div>
        </div>
    </div>
</div>
