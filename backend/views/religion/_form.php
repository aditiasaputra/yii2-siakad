<?php

use common\models\Region;
use common\models\Religion;
use common\models\Role;
use kartik\date\DatePicker;
use kartik\depdrop\DepDrop;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use common\widgets\Alert;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var common\models\User $model */
/** @var yii\widgets\ActiveForm $form */

$assetDir = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');

$avatars = ['avatar.png', 'avatar2.png', 'avatar3.png', 'avatar4.png', 'avatar5.png'];
// $assetDir = Yii::getAlias('@web/img/');

$this->registerCss(<<<CSS
    .avatar-choice {
        border: 2px solid transparent;
    }
    input[type="radio"]:checked + .avatar-choice {
        border-color: #007bff;
    }
CSS
);



?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header">
        <h1 class="card-title">Form Pengguna</h1>
    </div>
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data', 'autocomplete' => 'off']
    ]); ?>
        <div class="card-body">

            <div class="row">
                <div class="col-lg-12 col-md-12 col-12">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
                </div>
            </div>

        </div>

        <div class="card-footer d-flex">
            <?php if (!$model->isNewRecord): ?>
                <div id="action-left">
                    <?= Html::a('Kembali', ['show', 'id' => $model->id], [
                        'class' => 'btn btn-sm btn-default'
                    ]) ?>
                </div>
            <?php endif; ?>
            <div class="ml-auto" id="action-right">
                <?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Batal</span>', Url::to(['index']), ['class' => 'btn btn-sm btn-secondary mr-1']) ?>
                <?= Html::submitButton('<i class="fas fa-fw fa-check"></i><span> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah') . '</span>', ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
