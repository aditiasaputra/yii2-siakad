<?php
use yii\helpers\Html;
$this->title = 'Ubah Prasyarat Mata Kuliah';
$this->params['breadcrumbs'][] = ['label' => 'Prasyarat Mata Kuliah', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="subject-prerequisite-update"><div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index', 'study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId], ['class' => 'btn btn-outline-secondary']) ?></div><?= $this->render('_form', compact('model', 'curriculumOptions', 'studyProgramId', 'curriculumYearId')) ?></div>
