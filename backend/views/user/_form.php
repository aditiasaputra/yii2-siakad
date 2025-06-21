<?php

use common\models\Role;
use kartik\date\DatePicker;
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

$this->registerJs(<<<JS
    $('.avatar-choice').on('click', function () {
        $(this).siblings('input[type="radio"]').prop('checked', true).trigger('change');
        $('.avatar-choice').css('border-color', 'transparent');
        $(this).css('border-color', '#007bff');
        $('.file-preview-image').attr('src', $(this).attr('src'));
    });
    // $('.avatar-choice').eq(0).trigger('click');
JS
);
if (!$model->isNewRecord) {
    $image = Html::encode($model->image);

    $this->registerJs(<<<JS
        $(function() {
            const avatarChoice = $('.avatar-choice[src*="$image"]');
            avatarChoice.trigger('click');
        });
    JS);
}


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
                <div class="col-lg-5 col-md-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($model, 'personal_id')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($model, 'family_id')->textInput(['maxlength' => true, 'autofocus' => true]) ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($model, 'role_id')->widget(Select2::class, [
                                'data' => ArrayHelper::map(
                                    Role::find()->select(['id', 'name'])->asArray()->all(),
                                    'id', 'name'
                                ),
                                'options' => ['placeholder' => '-- Pilih Role --', 'value' => $model->role_id],
                                'pluginOptions' => ['allowClear' => true],
                            ])->label('Role') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'gender')->widget(Select2::class, [
                                'data' => [
                                    1 => 'Laki-laki',
                                    0 => 'Perempuan',
                                ],
                                'options' => ['placeholder' => '-- Pilih Jenis Kelamin --'],
                                'pluginOptions' => ['allowClear' => true],
                            ])->label('Jenis Kelamin') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'address')->textarea([
                                'rows' => 3,
                                'class' => 'form-control form-control-user',
                                'placeholder' => 'Masukkan Alamat Lengkap...',
                                'autofocus' => true
                            ])->label('Alamat') ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-12">
                            <?= $form->field($model, 'status')->widget(Select2::class, [
                                'data' => [
                                    10 => 'Active',
                                    0 => 'Inactive',
                                ],
                                'options' => ['placeholder' => '-- Pilih Status --', 'value' => $model->status ?? 10],
                                'pluginOptions' => ['allowClear' => true],
                            ]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <?= $form->field($model, 'birth_date')->widget(DatePicker::class, [
                                'type' => DatePicker::TYPE_COMPONENT_APPEND,
                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'autoclose' => true,
                                    'todayHighlight' => true,
                                    'todayBtn' => true,
                                    'clearBtn' => true,
                                    'endDate' => date('Y-m-d'),
                                ]
                            ])->label('Tanggal Lahir') ?>
                        </div>
                        <div class="col-md-12">
                            <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                        </div>
                        <?php if ($model->isNewRecord): ?>
                            <div class="col-lg-12 col-md-12 col-12">
                                <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>
                            </div>
                        <?php endif; ?>
                        <div class="col-md-12 mb-3">
                            <label class="form-label"><strong>Pilih Avatar</strong></label>
                            <div class="d-flex justify-content-evenly flex-wrap gap-4">
                                <?php foreach ($avatars as $avatar): ?>
                                    <label class="text-center">
                                        <input type="radio" name="User[avatar]" value="<?= 'img/' . $avatar ?>"
                                            <?= ($model->image === 'img/' . $avatar) ? 'checked' : '' ?> style="display: none;">
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
                                    'initialPreview' => ($model->isNewRecord || !$model->image
                                    ? false
                                    : [Yii::getAlias('@web/uploads/' . $model->image)]),
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
