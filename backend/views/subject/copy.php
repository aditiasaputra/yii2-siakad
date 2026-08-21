<?php

use common\widgets\Alert;
use yii\helpers\Html;

$this->title = 'Salin Mata Kuliah';
$this->params['breadcrumbs'][] = ['label' => 'Mata Kuliah', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Alert::widget() ?>
<div class="subject-copy">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="card card-warning card-outline"><div class="card-body">
        <?= Html::beginForm(['copy'], 'post') ?>
        <div class="row">
            <div class="col-12"><h5 class="border-bottom pb-2">Sumber</h5></div>
            <div class="col-md-6"><label>Program Studi Sumber</label><?= Html::dropDownList('source_study_program_id', null, $studyPrograms, ['class' => 'form-control', 'prompt' => '- Pilih Prodi -', 'required' => true]) ?></div>
            <div class="col-md-6"><label>Tahun Kurikulum Sumber</label><?= Html::dropDownList('source_curriculum_year_id', null, $curriculumYears, ['class' => 'form-control', 'prompt' => '- Pilih Kurikulum -', 'required' => true]) ?></div>
            <div class="col-12 mt-4"><h5 class="border-bottom pb-2">Tujuan</h5></div>
            <div class="col-md-6"><label>Program Studi Tujuan</label><?= Html::dropDownList('target_study_program_id', null, $studyPrograms, ['class' => 'form-control', 'prompt' => '- Pilih Prodi -', 'required' => true]) ?></div>
            <div class="col-md-6"><label>Tahun Kurikulum Tujuan</label><?= Html::dropDownList('target_curriculum_year_id', null, $curriculumYears, ['class' => 'form-control', 'prompt' => '- Pilih Kurikulum -', 'required' => true]) ?></div>
        </div>
        <div class="text-right mt-4"><?= Html::a('Batal', ['index'], ['class' => 'btn btn-secondary']) ?> <?= Html::submitButton('<i class="fas fa-copy"></i> Salin Mata Kuliah', ['class' => 'btn btn-warning', 'data' => ['confirm' => 'Salin seluruh Mata Kuliah ke tujuan yang dipilih?']]) ?></div>
        <?= Html::endForm() ?>
    </div></div>
</div>
