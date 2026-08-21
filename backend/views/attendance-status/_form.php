<?php

use common\widgets\Alert;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Status Hadir' : 'Form Ubah Status Hadir' ?></h3></div>
    <?php $form = ActiveForm::begin(['id' => 'attendance-status-form', 'options' => ['autocomplete' => 'off'], 'enableClientValidation' => true]); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12"><?= $form->field($model, 'code')->textInput(['maxlength' => true, 'autofocus' => true, 'style' => 'text-transform: uppercase', 'placeholder' => 'Contoh: H'])->hint('Gunakan singkatan yang sesuai dengan status kehadiran.') ?></div>
            <div class="col-lg-8 col-md-8 col-12"><?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: Hadir']) ?></div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-4 col-12"><?= $form->field($model, 'counts_as_present')->checkbox() ?></div>
            <div class="col-lg-4 col-md-4 col-12"><?= $form->field($model, 'applies_to_lecturers')->checkbox() ?></div>
            <div class="col-lg-4 col-md-4 col-12"><?= $form->field($model, 'applies_to_students')->checkbox() ?></div>
        </div>
    </div>
    <div class="card-footer d-flex">
        <?php if (!$model->isNewRecord): ?><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Kembali</span>', Url::to(['index']), ['class' => 'btn btn-sm btn-default']) ?><?php endif; ?>
        <div class="ml-auto"><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Batal</span>', $model->isNewRecord ? Url::to(['index']) : Url::to(['view', 'id' => $model->id]), ['class' => 'btn btn-sm btn-secondary mr-1']) ?><?= Html::submitButton('<i class="fas fa-fw fa-check"></i><span> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah') . '</span>', ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?></div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
