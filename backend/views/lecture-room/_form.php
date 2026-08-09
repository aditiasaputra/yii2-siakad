<?php

use backend\models\StudyProgram;
use common\widgets\Alert;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$programs = ArrayHelper::map(StudyProgram::find()->orderBy('name')->all(), 'id', 'name');
?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Ruang Kuliah' : 'Form Ubah Ruang Kuliah' ?></h3></div>
    <?php $form = ActiveForm::begin(['id' => 'lecture-room-form', 'options' => ['autocomplete' => 'off'], 'enableClientValidation' => true, 'validateOnChange' => true, 'validateOnSubmit' => true]); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <?= $form->field($model, 'study_program_id')->dropDownList($programs, ['prompt' => '- Pilih Unit / Program Studi -']) ?>
                <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'autofocus' => true, 'inputmode' => 'numeric', 'placeholder' => 'Contoh: 01']) ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: Ruang Kuliah 1']) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <?= $form->field($model, 'location')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: G.202']) ?>
                <?= $form->field($model, 'capacity')->input('number', ['min' => 1, 'placeholder' => 'Contoh: 30']) ?>
                <?= $form->field($model, 'is_active')->widget(SwitchInput::class, ['pluginOptions' => ['onText' => 'Aktif', 'offText' => 'Nonaktif', 'onColor' => 'success', 'offColor' => 'danger']]) ?>
            </div>
        </div>
    </div>
    <div class="card-footer d-flex">
        <?php if (!$model->isNewRecord): ?><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Kembali</span>', Url::to(['index']), ['class' => 'btn btn-sm btn-default']) ?><?php endif; ?>
        <div class="ml-auto" id="action-right">
            <?= Html::a('<i class="fas fa-fw fa-arrow-left"></i><span> Batal</span>', $model->isNewRecord ? Url::to(['index']) : Url::to(['view', 'id' => $model->id]), ['class' => 'btn btn-sm btn-secondary mr-1']) ?>
            <?= Html::submitButton('<i class="fas fa-fw fa-check"></i><span> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah') . '</span>', ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
