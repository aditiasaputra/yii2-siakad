<?php

/** @var yii\web\View$this  */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\ResetPasswordForm $model */

use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Resend verification email';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-resend-verification-email">

    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h1 class="text-center"><?= Html::encode($this->title) ?></h1>
            <p class="text-center">Please fill out your email. A verification email will be sent there.</p>

            <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form']); ?>

            <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Send', ['class' => 'btn btn-primary w-100']) ?>
            </div>

            <hr>
            <div class="my-1 mx-0" style="color:#999;">
                <?= Html::a('I already account', ['site/login']) ?>.
                <br>
                <?= Html::a('I forgot my password', ['site/request-password-reset']) ?>.
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
