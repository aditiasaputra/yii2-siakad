<?php
use yii\helpers\Html;
$this->title = 'Ubah Data Kurikulum';
$this->params['breadcrumbs'][] = ['label' => 'Kurikulum Prodi', 'url' => ['index', 'study_program_id' => $model->study_program_id, 'curriculum_year_id' => $model->curriculum_year_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-program-curriculum-update"><div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index', 'study_program_id' => $model->study_program_id, 'curriculum_year_id' => $model->curriculum_year_id], ['class' => 'btn btn-outline-secondary']) ?></div><?= $this->render('_form', compact('model', 'subjects')) ?></div>
