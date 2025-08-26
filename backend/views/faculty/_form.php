<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\switchinput\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Faculty */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="faculty-form">
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">
                <i class="fas fa-university"></i>
                <?= $model->isNewRecord ? 'Tambah Fakultas Baru' : 'Edit Fakultas' ?>
            </h5>
        </div>
        
        <div class="card-body">
            <?php $form = ActiveForm::begin([
                'id' => 'faculty-form',
                'options' => ['class' => 'form-horizontal'],
                'fieldConfig' => [
                    'template' => '<div class="row"><div class="col-sm-3">{label}</div><div class="col-sm-9">{input}{error}</div></div>',
                    'labelOptions' => ['class' => 'col-form-label'],
                ],
            ]); ?>
            
            <div class="row">
                <div class="col-md-6">
                    <h6 class="text-primary border-bottom pb-2 mb-3">
                        <i class="fas fa-info-circle"></i> Informasi Dasar
                    </h6>
                    
                    <?= $form->field($model, 'unit_code')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Contoh: FK, FT, FMIPA'
                    ]) ?>

                    <?= $form->field($model, 'unit_name')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Nama lengkap fakultas'
                    ]) ?>

                    <?= $form->field($model, 'unit_name_en')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'English name (optional)'
                    ]) ?>

                    <?= $form->field($model, 'abbreviation')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Singkatan fakultas'
                    ]) ?>

                    <?= $form->field($model, 'work_unit')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Unit/Satuan Kerja'
                    ]) ?>

                    <?= $form->field($model, 'phone')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Nomor telepon fakultas'
                    ]) ?>
                </div>
                
                <div class="col-md-6">
                    <h6 class="text-primary border-bottom pb-2 mb-3">
                        <i class="fas fa-users"></i> Pimpinan Fakultas
                    </h6>
                    
                    <?= $form->field($model, 'dean')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Nama dekan'
                    ]) ?>

                    <?= $form->field($model, 'vice_dean_1')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Nama wakil dekan 1'
                    ]) ?>

                    <?= $form->field($model, 'vice_dean_2')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Nama wakil dekan 2'
                    ]) ?>

                    <?= $form->field($model, 'vice_dean_3')->textInput([
                        'maxlength' => true,
                        'placeholder' => 'Nama wakil dekan 3'
                    ]) ?>
                    
                    <h6 class="text-primary border-bottom pb-2 mb-3 mt-4">
                        <i class="fas fa-cog"></i> Status
                    </h6>
                    
                    <?= $form->field($model, 'is_active')->widget(SwitchInput::class, [
                        'pluginOptions' => [
                            'onText' => 'Aktif',
                            'offText' => 'Nonaktif',
                            'onColor' => 'success',
                            'offColor' => 'danger',
                            'size' => 'normal',
                        ]
                    ]) ?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <h6 class="text-primary border-bottom pb-2 mb-3">
                        <i class="fas fa-map-marker-alt"></i> Alamat
                    </h6>
                    
                    <?= $form->field($model, 'address')->textarea([
                        'rows' => 4,
                        'placeholder' => 'Alamat lengkap fakultas'
                    ]) ?>
                </div>
            </div>
        </div>
        
        <div class="card-footer d-flex justify-content-end">
            <?= Html::submitButton($model->isNewRecord ? '<i class="fas fa-save"></i> Simpan' : '<i class="fas fa-save"></i> Perbarui', [
                'class' => 'btn btn-' . ($model->isNewRecord ? 'success' : 'warning')
            ]) ?>
            
            <?= Html::a('<i class="fas fa-times"></i> Batal', ['index'], [
                'class' => 'btn btn-secondary ml-2'
            ]) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<style>
.card-header {
    background-color: #f8f9fa;
}

.form-group {
    margin-bottom: 1rem;
}

.text-primary {
    color: #007bff !important;
}

.border-bottom {
    border-bottom: 1px solid #dee2e6 !important;
}

h6 i {
    margin-right: 8px;
}
</style>