<?php

use common\widgets\Alert;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Golongan' : 'Form Ubah Golongan' ?></h3></div>
    <?php $form = ActiveForm::begin(['id' => 'rank-form', 'options' => ['autocomplete' => 'off'], 'enableClientValidation' => true]); ?>
    <div class="card-body"><div class="row">
        <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'code')->textInput(['maxlength' => true, 'autofocus' => true, 'placeholder' => 'Contoh: III A'])->hint('Gunakan angka Romawi dan huruf, misalnya I A atau IV E.') ?></div>
        <div class="col-lg-6 col-md-6 col-12"><?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: Penata Muda'])->hint('Masukkan nama golongan.') ?></div>
    </div></div>
    <div class="card-footer d-flex">
        <?php if (!$model->isNewRecord): ?><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Kembali</span>', Url::to(['index']), ['class' => 'btn btn-sm btn-default']) ?><?php endif; ?>
        <div class="ml-auto"><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Batal</span>', $model->isNewRecord ? Url::to(['index']) : Url::to(['view', 'id' => $model->id]), ['class' => 'btn btn-sm btn-secondary mr-1']) ?><?= Html::submitButton('<i class="fas fa-fw fa-check"></i><span> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah') . '</span>', ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?></div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
