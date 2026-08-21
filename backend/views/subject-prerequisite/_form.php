<?php

use backend\models\StudyProgram;
use backend\models\CurriculumYear;
use backend\models\StudyProgramCurriculum;
use backend\models\SubjectPrerequisite;
use common\widgets\Alert;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;

$backUrl = ['index', 'study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId];
$studyProgram = StudyProgram::findOne($studyProgramId);
$curriculumYear = CurriculumYear::findOne($curriculumYearId);
?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Prasyarat Mata Kuliah' : 'Form Ubah Prasyarat Mata Kuliah' ?></h3></div>
    <?php $form = ActiveForm::begin(['id' => 'subject-prerequisite-form', 'options' => ['autocomplete' => 'off'], 'enableClientValidation' => true]); ?>
    <div class="card-body">
        <div class="row mb-3"><div class="col-md-6"><label>Program Studi</label><div class="form-control bg-light"><?= Html::encode($studyProgram->name ?? '-') ?></div></div><div class="col-md-6"><label>Tahun Kurikulum</label><div class="form-control bg-light"><?= Html::encode($curriculumYear->year ?? '-') ?></div></div></div>
        <div class="row">
            <div class="col-md-6"><?= $form->field($model, 'course_curriculum_id')->widget(Select2::class, ['data' => $curriculumOptions, 'options' => ['placeholder' => '- Pilih Mata Kuliah -', 'autofocus' => true], 'pluginOptions' => ['allowClear' => true]]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'prerequisite_curriculum_id')->widget(Select2::class, ['data' => $curriculumOptions, 'options' => ['placeholder' => '- Pilih Prasyarat -'], 'pluginOptions' => ['allowClear' => true]]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'requirement_type')->dropDownList(SubjectPrerequisite::typeOptions()) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'minimum_grade')->dropDownList(StudyProgramCurriculum::gradeOptions(), ['prompt' => 'Tidak Ada']) ?></div>
        </div>
    </div>
    <div class="card-footer d-flex"><?php if (!$model->isNewRecord): ?><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i> Kembali', Url::to($backUrl), ['class' => 'btn btn-sm btn-default']) ?><?php endif; ?><div class="ml-auto"><?= Html::a('<i class="fas fa-fw fa-arrow-left"></i> Batal', Url::to($backUrl), ['class' => 'btn btn-sm btn-secondary mr-1']) ?><?= Html::submitButton('<i class="fas fa-fw fa-check"></i> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah'), ['class' => 'btn btn-sm btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?></div></div>
    <?php ActiveForm::end(); ?>
</div>
