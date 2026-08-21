<?php

use common\widgets\Alert;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;

$backUrl = ['index', 'study_program_id' => $model->study_program_id, 'new_curriculum_year_id' => $model->new_curriculum_year_id, 'old_curriculum_year_id' => $model->old_curriculum_year_id];
?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Ekivalensi Mata Kuliah' : 'Form Ubah Ekivalensi Mata Kuliah' ?></h3></div>
    <?php $form = ActiveForm::begin(['id' => 'subject-equivalence-form', 'options' => ['autocomplete' => 'off'], 'enableClientValidation' => true]); ?>
    <div class="card-body">
        <?= $form->field($model, 'study_program_id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'new_curriculum_year_id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'old_curriculum_year_id')->hiddenInput()->label(false) ?>
        <div class="row mb-3">
            <div class="col-lg-4"><label>Program Studi</label><div class="form-control bg-light"><?= Html::encode($model->studyProgram->name) ?></div></div>
            <div class="col-lg-4"><label>Kurikulum Baru</label><div class="form-control bg-light"><?= Html::encode($model->newCurriculumYear->year) ?></div></div>
            <div class="col-lg-4"><label>Kurikulum Lama</label><div class="form-control bg-light"><?= Html::encode($model->oldCurriculumYear->year) ?></div></div>
        </div>
        <div class="row">
            <div class="col-lg-6"><?= $form->field($model, 'new_subject_id')->widget(Select2::class, ['data' => $newSubjects, 'options' => ['placeholder' => '- Pilih Mata Kuliah Kurikulum Baru -', 'autofocus' => true], 'pluginOptions' => ['allowClear' => true]]) ?></div>
            <div class="col-lg-6"><?= $form->field($model, 'old_subject_id')->widget(Select2::class, ['data' => $oldSubjects, 'options' => ['placeholder' => '- Pilih Mata Kuliah Kurikulum Lama -'], 'pluginOptions' => ['allowClear' => true]]) ?></div>
        </div>
    </div>
    <div class="card-footer d-flex">
        <?php if (!$model->isNewRecord): ?><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i> Kembali', Url::to($backUrl), ['class' => 'btn btn-sm btn-default']) ?><?php endif; ?>
        <div class="ml-auto"><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i> Batal', Url::to($backUrl), ['class' => 'btn btn-sm btn-secondary mr-1']) ?><?= Html::submitButton('<i class="fas fa-fw fa-check"></i> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah'), ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?></div>
    </div>
    <?php ActiveForm::end(); ?>
</div>
