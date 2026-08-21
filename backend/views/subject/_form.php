<?php

use common\widgets\Alert;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
?>
<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Mata Kuliah' : 'Form Ubah Mata Kuliah' ?></h3></div>
    <?php $form = ActiveForm::begin(['id' => 'subject-form', 'options' => ['autocomplete' => 'off']]); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4"><?= $form->field($model, 'curriculum_year_id')->widget(Select2::class, ['data' => $curriculumYears, 'options' => ['placeholder' => '- Pilih Tahun Kurikulum -']]) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'code')->textInput(['maxlength' => true, 'style' => 'text-transform:uppercase', 'placeholder' => 'Contoh: IF202801']) ?></div>
            <div class="col-md-4"><?= $form->field($model, 'study_program_id')->widget(Select2::class, ['data' => $studyPrograms, 'options' => ['placeholder' => '- Pilih Program Studi -']]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'name_en')->textInput(['maxlength' => true]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'subject_type_id')->widget(Select2::class, ['data' => $subjectTypes, 'options' => ['placeholder' => '- Pilih Jenis -']]) ?></div>
            <div class="col-md-6"><?= $form->field($model, 'subject_group_id')->widget(Select2::class, ['data' => $subjectGroups, 'options' => ['placeholder' => '- Pilih Kelompok -']]) ?></div>
            <div class="col-12"><?= $form->field($model, 'lecturer_ids')->widget(Select2::class, ['data' => $lecturers, 'options' => ['multiple' => true, 'placeholder' => '- Pilih Dosen Pengampu -'], 'pluginOptions' => ['allowClear' => true]]) ?></div>
        </div>
        <h5 class="border-bottom pb-2 mt-3">Bobot SKS</h5>
        <div class="row">
            <?php foreach (['credits', 'face_to_face_credits', 'practicum_credits', 'lab_credits', 'ksk_credits', 'pbl_credits'] as $attribute): ?>
                <div class="col-lg-2 col-md-4 col-6"><?= $form->field($model, $attribute)->textInput(['type' => 'number', 'min' => 0, 'max' => 99, 'step' => '0.5']) ?></div>
            <?php endforeach; ?>
        </div>
        <h5 class="border-bottom pb-2 mt-3">Dokumen Pendukung</h5>
        <div class="row">
            <?php foreach (['mku', 'sap', 'syllabus', 'teaching_material', 'module'] as $attribute): ?>
                <div class="col-lg-4 col-md-6"><?= $form->field($model, $attribute)->textInput(['maxlength' => true, 'placeholder' => 'Nama atau tautan dokumen']) ?></div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="card-footer d-flex"><div class="ml-auto"><?= Html::a('<i class="fas fa-arrow-left"></i> Batal', $model->isNewRecord ? Url::to(['index']) : Url::to(['view', 'id' => $model->id]), ['class' => 'btn btn-secondary mr-1']) ?><?= Html::submitButton('<i class="fas fa-check"></i> ' . ($model->isNewRecord ? 'Simpan' : 'Ubah'), ['class' => 'btn btn-' . ($model->isNewRecord ? 'success' : 'warning')]) ?></div></div>
    <?php ActiveForm::end(); ?>
</div>
