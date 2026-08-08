<?php

use common\widgets\Alert;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;
use yii\helpers\Html;
use yii\helpers\Url;

/** @var yii\web\View $this */
/** @var backend\models\Faculty $model */
/** @var kartik\form\ActiveForm $form */
?>

<?= Alert::widget() ?>

<div class="card card-primary card-outline mb-3">
    <div class="card-header">
        <h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Fakultas' : 'Form Ubah Fakultas' ?></h3>
    </div>

    <?php $form = ActiveForm::begin([
        'id' => 'faculty-form',
        'options' => ['autocomplete' => 'off'],
        'enableClientValidation' => true,
        'validateOnChange' => true,
        'validateOnSubmit' => true,
    ]); ?>

    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="mb-3 text-primary">Informasi Dasar</h5>
                <hr>
                <?= $form->field($model, 'unit_code')->textInput(['maxlength' => true, 'autofocus' => true, 'placeholder' => 'Contoh: FK, FT, FMIPA']) ?>
                <?= $form->field($model, 'unit_name')->textInput(['maxlength' => true, 'placeholder' => 'Nama lengkap fakultas']) ?>
                <?= $form->field($model, 'unit_name_en')->textInput(['maxlength' => true, 'placeholder' => 'English name (optional)']) ?>
                <?= $form->field($model, 'abbreviation')->textInput(['maxlength' => true, 'placeholder' => 'Singkatan fakultas']) ?>
                <?= $form->field($model, 'work_unit')->textInput(['maxlength' => true, 'placeholder' => 'Unit/Satuan Kerja']) ?>
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Nomor telepon fakultas']) ?>
            </div>

            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="mb-3 text-primary">Pimpinan Fakultas</h5>
                <hr>
                <?= $form->field($model, 'dean')->textInput(['maxlength' => true, 'placeholder' => 'Nama dekan']) ?>
                <?= $form->field($model, 'vice_dean_1')->textInput(['maxlength' => true, 'placeholder' => 'Nama wakil dekan 1']) ?>
                <?= $form->field($model, 'vice_dean_2')->textInput(['maxlength' => true, 'placeholder' => 'Nama wakil dekan 2']) ?>
                <?= $form->field($model, 'vice_dean_3')->textInput(['maxlength' => true, 'placeholder' => 'Nama wakil dekan 3']) ?>
                <?= $form->field($model, 'is_active')->widget(SwitchInput::class, [
                    'pluginOptions' => [
                        'onText' => 'Aktif',
                        'offText' => 'Nonaktif',
                        'onColor' => 'success',
                        'offColor' => 'danger',
                    ],
                ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <h5 class="mt-4 mb-3 text-primary">Alamat</h5>
                <hr>
                <?= $form->field($model, 'address')->textarea(['rows' => 4, 'placeholder' => 'Alamat lengkap fakultas']) ?>
            </div>
        </div>
    </div>

    <div class="card-footer d-flex">
        <?php if (!$model->isNewRecord): ?>
            <?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Kembali</span>', Url::to(['index']), ['class' => 'btn btn-sm btn-default']) ?>
        <?php endif; ?>
        <div class="ml-auto" id="action-right">
            <?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Batal</span>', $model->isNewRecord ? Url::to(['index']) : Url::to(['show', 'id' => $model->id]), ['class' => 'btn btn-sm btn-secondary mr-1']) ?>
            <?= Html::submitButton('<i class="fas fa-fw fa-check"></i><span> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah') . '</span>', ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>
