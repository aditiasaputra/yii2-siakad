<?php

use common\models\Role;
use kartik\file\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
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

$this->registerJs(<<<JS
    $('.avatar-choice').on('click', function () {
        $(this).siblings('input[type="radio"]').prop('checked', true).trigger('change');
        $('.avatar-choice').css('border-color', 'transparent');
        $(this).css('border-color', '#007bff');
        $('.file-preview-image').attr('src', $(this).attr('src'));
    });
JS
);


?>

<div class="card card-primary card-outline mb-3">
    <div class="card-header">
        <h1 class="card-title">Form User</h1>
    </div>
    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
        <div class="card-body">

            <div class="row">
                <div class="col-lg-4 col-md-12 col-4">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-12 col-4">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4 col-md-12 col-4">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'role_id')->widget(\kartik\select2\Select2::class, [
                        'data' => \yii\helpers\ArrayHelper::map(\common\models\Role::find()->all(), 'id', 'name'), // ganti 'name' jika kolomnya beda
                        'options' => [
                            'placeholder' => '-- Select Role --',
                        ],
                        'pluginOptions' => [
                            'allowClear' => true
                        ],
                    ]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'status')->widget(Select2::class, [
                        'data' => [
                            10 => 'Active',
                            0 => 'Inactive',
                        ],
                        'options' => ['placeholder' => 'Select status...'],
                        'pluginOptions' => ['allowClear' => true],
                    ]) ?>
                </div>
            </div>

            <?php if ($model->isNewRecord): ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label"><strong>Pilih Avatar</strong></label>
                    <div class="d-flex justify-content-evenly flex-wrap gap-4">
                        <?php foreach ($avatars as $avatar): ?>
                            <label class="text-center">
                                <input type="radio" name="User[image]" value="<?= 'img/' . $avatar ?>"
                                    <?= ($model->image === '/img/' . $avatar) ? 'checked' : '' ?> style="display: none;">
                                <img src="<?= $assetDir . '/img/' . $avatar ?>" class="img-thumbnail avatar-choice" style="width: 80px; height: 80px; cursor: pointer;">
                            </label>
                        <?php endforeach; ?>
                    </div>
                    <div class="form-text text-muted mt-2">Atau upload gambar kustom di bawah ini</div>
                </div>

                <div class="col-md-12">
                    <?= $form->field($model, 'image')->widget(FileInput::class, [
                        'options' => ['accept' => 'image/*'],
                        'pluginOptions' => [
                            'initialPreview' =>
                                $model->isNewRecord || !$model->image || str_contains($model->image, 'img/')
                                    ? $assetDir . $model->image
                                    : [Yii::getAlias('@web/uploads/' . $model->image)],
                            'initialPreviewAsData' => true,
                            'initialCaption' => $model->image,
                            'overwriteInitial' => true,
                            'showRemove' => true,
                            'showUpload' => false,
                        ]
                    ]) ?>
                </div>
            </div>

        </div>



        <div class="card-footer d-flex justify-content-end">
            <?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Batal</span>', Url::to(['url/index']), ['class' => 'btn btn-default mr-1']) ?>
            <?= Html::submitButton('<i class="fas fa-fw fa-check"></i><span> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah') . '</span>', ['class' => 'btn btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?>
        </div>

    <?php ActiveForm::end(); ?>

</div>
