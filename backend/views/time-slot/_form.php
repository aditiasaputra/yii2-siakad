<?php

use common\widgets\Alert;
use kartik\form\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Slot Waktu' : 'Form Ubah Slot Waktu' ?></h3></div>
    <?php $form = ActiveForm::begin(['id' => 'time-slot-form', 'options' => ['autocomplete' => 'off'], 'enableClientValidation' => true]); ?>
    <div class="card-body">
        <div class="row"><div class="col-lg-4 col-md-6 col-12"><?= $form->field($model, 'time')->input('time', ['autofocus' => true, 'step' => 60])->hint('Masukkan waktu dalam format 24 jam. Waktu yang sama tidak dapat ditambahkan dua kali.') ?></div></div>
    </div>
    <div class="card-footer d-flex">
        <?php if (!$model->isNewRecord): ?><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Kembali</span>', Url::to(['index']), ['class' => 'btn btn-sm btn-default']) ?><?php endif; ?>
        <div class="ml-auto"><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Batal</span>', Url::to(['index']), ['class' => 'btn btn-sm btn-secondary mr-1']) ?><?= Html::submitButton('<i class="fas fa-fw fa-check"></i><span> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah') . '</span>', ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?></div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
