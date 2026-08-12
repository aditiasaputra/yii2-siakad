<?php

use common\models\Region;
use common\widgets\Alert;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$parentLevel = ['regency' => 'province', 'district' => 'regency'][$level] ?? null;
$parents = $parentLevel === null ? [] : ArrayHelper::map(Region::find()->where(['level' => $parentLevel])->orderBy('name')->all(), 'kode', static fn($item) => $item->kode . ' - ' . $item->name);
$label = Region::levelLabels()[$level];
?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah ' . $label : 'Form Ubah ' . $label ?></h3></div>
    <?php $form = ActiveForm::begin(['id' => 'region-form', 'options' => ['autocomplete' => 'off'], 'enableClientValidation' => true]); ?>
    <div class="card-body"><div class="row">
        <div class="col-12"><?= $form->field($model, 'name')->textInput(['maxlength' => true, 'autofocus' => true, 'placeholder' => 'Nama ' . $label]) ?></div>
        <?php if ($parentLevel !== null): ?><div class="col-12"><?= $form->field($model, 'parent_kode')->widget(Select2::class, ['data' => $parents, 'options' => ['placeholder' => '-- Pilih ' . Region::levelLabels()[$parentLevel] . ' --', 'disabled' => !$model->isNewRecord], 'pluginOptions' => ['allowClear' => false]]) ?></div><?php endif; ?>
    </div></div>
    <div class="card-footer d-flex"><div class="ml-auto"><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i> Batal', $model->isNewRecord ? Url::to(['index', '#' => $level]) : Url::to(['view', 'kode' => $model->kode]), ['class' => 'btn btn-sm btn-secondary mr-1']) ?><?= Html::submitButton('<i class="fas fa-fw fa-check"></i> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah'), ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?></div></div>
    <?php ActiveForm::end(); ?>
</div>
