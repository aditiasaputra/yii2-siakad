<?php

use backend\models\Faculty;
use common\widgets\Alert;
use kartik\form\ActiveForm;
use kartik\switchinput\SwitchInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$facultyOptions = ArrayHelper::map(Faculty::find()->orderBy('unit_name')->all(), 'id', 'unit_name');
$educationLevels = ['D1' => 'D1 - Diploma Satu', 'D2' => 'D2 - Diploma Dua', 'D3' => 'D3 - Diploma Tiga', 'D4' => 'D4 - Sarjana Terapan', 'S1' => 'S1 - Strata Satu', 'S2' => 'S2 - Strata Dua', 'S3' => 'S3 - Strata Tiga'];
$accreditations = ['Unggul' => 'Unggul', 'Baik Sekali' => 'Baik Sekali', 'Baik' => 'Baik', 'A' => 'A', 'B' => 'B', 'C' => 'C'];
?>

<?= Alert::widget() ?>
<div class="card card-primary card-outline mb-3">
    <div class="card-header"><h3 class="card-title mb-0"><?= $model->isNewRecord ? 'Form Tambah Program Studi' : 'Form Ubah Program Studi' ?></h3></div>
    <?php $form = ActiveForm::begin([
        'id' => 'study-program-form',
        'options' => ['autocomplete' => 'off'],
        'enableClientValidation' => true,
        'validateOnChange' => true,
        'validateOnSubmit' => true,
    ]); ?>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="mb-3 text-primary">Informasi Dasar</h5><hr>
                <?= $form->field($model, 'faculty_id')->dropDownList($facultyOptions, ['prompt' => '- Pilih Fakultas -']) ?>
                <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'autofocus' => true, 'placeholder' => 'Contoh: 400250']) ?>
                <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Nama program studi']) ?>
                <?= $form->field($model, 'name_en')->textInput(['maxlength' => true, 'placeholder' => 'Program name in English']) ?>
                <?= $form->field($model, 'short_name')->textInput(['maxlength' => true, 'placeholder' => 'Singkatan program studi']) ?>
                <?= $form->field($model, 'address')->textarea(['rows' => 3, 'placeholder' => 'Alamat program studi']) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="mb-3 text-primary">Informasi Operasional</h5><hr>
                <?= $form->field($model, 'program_type')->dropDownList($educationLevels, ['prompt' => '- Pilih Tingkat Pendidikan -']) ?>
                <?= $form->field($model, 'work_unit')->textInput(['maxlength' => true, 'placeholder' => 'Unit/Satuan Kerja']) ?>
                <?= $form->field($model, 'phone')->textInput(['maxlength' => true, 'placeholder' => 'Nomor telepon']) ?>
                <?= $form->field($model, 'is_active')->widget(SwitchInput::class, ['pluginOptions' => ['onText' => 'Aktif', 'offText' => 'Nonaktif', 'onColor' => 'success', 'offColor' => 'danger']]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <h5 class="mt-4 mb-3 text-primary">Pejabat Program Studi</h5><hr>
                <?= $form->field($model, 'head_of_program')->textInput(['maxlength' => true, 'placeholder' => 'Nama ketua program studi']) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-12"><h5 class="mt-4 mb-3 text-primary">&nbsp;</h5><hr>
                <?= $form->field($model, 'secretary_of_program')->textInput(['maxlength' => true, 'placeholder' => 'Nama sekretaris program studi']) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12"><h5 class="mt-4 mb-3 text-primary">Informasi Akademik</h5><hr></div>
            <div class="col-lg-6 col-md-6 col-12">
                <?= $form->field($model, 'nim_prefix')->textInput(['maxlength' => true, 'placeholder' => 'Kode NIM']) ?>
                <?= $form->field($model, 'minimum_graduation_credits')->input('number', ['min' => 0]) ?>
                <?= $form->field($model, 'minimum_graduation_gpa')->input('number', ['min' => 0, 'max' => 4, 'step' => '0.01']) ?>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <?= $form->field($model, 'degree')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: Sarjana Bahasa']) ?>
                <?= $form->field($model, 'degree_abbreviation')->textInput(['maxlength' => true, 'placeholder' => 'Contoh: S.Ba.']) ?>
                <?= $form->field($model, 'grade')->dropDownList($accreditations, ['prompt' => '- Pilih Akreditasi -']) ?>
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
