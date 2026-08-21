<?php

use backend\models\StudyProgramCurriculum;
use common\widgets\Alert;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;

$backUrl = ['index', 'study_program_id' => $model->study_program_id, 'curriculum_year_id' => $model->curriculum_year_id];
?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Kurikulum Prodi' : 'Form Ubah Kurikulum Prodi' ?></h3></div>
    <?php $form = ActiveForm::begin(['id' => 'study-program-curriculum-form', 'options' => ['autocomplete' => 'off'], 'enableClientValidation' => true]); ?>
    <div class="card-body">
        <?= $form->field($model, 'study_program_id')->hiddenInput()->label(false) ?><?= $form->field($model, 'curriculum_year_id')->hiddenInput()->label(false) ?>
        <div class="row mb-3"><div class="col-md-6"><label>Program Studi</label><div class="form-control bg-light"><?= Html::encode($model->studyProgram->name) ?></div></div><div class="col-md-6"><label>Tahun Kurikulum</label><div class="form-control bg-light"><?= Html::encode($model->curriculumYear->year) ?></div></div></div>
        <div class="row">
            <div class="col-md-8"><?= $form->field($model, 'subject_id')->widget(Select2::class, ['data' => $subjects, 'options' => ['placeholder' => '- Pilih Mata Kuliah -', 'disabled' => !$model->isNewRecord], 'pluginOptions' => ['allowClear' => $model->isNewRecord]]) ?><?php if (!$model->isNewRecord): ?><?= Html::activeHiddenInput($model, 'subject_id', ['id' => 'study-program-curriculum-subject-id-hidden']) ?><?php endif; ?></div>
            <div class="col-md-2"><?= $form->field($model, 'semester')->textInput(['type' => 'number', 'min' => 1, 'max' => 14]) ?></div>
            <div class="col-md-2"><?= $form->field($model, 'minimum_grade')->dropDownList(StudyProgramCurriculum::gradeOptions()) ?></div>
            <div class="col-md-3"><?= $form->field($model, 'is_mandatory')->checkbox() ?></div><div class="col-md-3"><?= $form->field($model, 'is_package')->checkbox() ?></div>
            <div class="col-md-3"><?= $form->field($model, 'minimum_credits')->textInput(['type' => 'number', 'min' => 0, 'step' => '.5']) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'topic')->textarea(['rows' => 4]) ?></div><div class="col-md-6"><?= $form->field($model, 'basic_competencies')->textarea(['rows' => 4]) ?></div>
        </div>
    </div>
    <div class="card-footer d-flex"><?php if (!$model->isNewRecord): ?><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i> Kembali', Url::to($backUrl), ['class' => 'btn btn-sm btn-default']) ?><?php endif; ?><div class="ml-auto"><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i> Batal', Url::to($backUrl), ['class' => 'btn btn-sm btn-secondary mr-1']) ?><?= Html::submitButton('<i class="fas fa-fw fa-check"></i> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah'), ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?></div></div>
    <?php ActiveForm::end(); ?>
</div>
