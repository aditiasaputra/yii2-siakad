<?php
use yii\helpers\Html;
$this->title = 'Ubah Data Kurikulum';
$this->params['breadcrumbs'][] = ['label' => 'Kurikulum Prodi', 'url' => ['index', 'study_program_id' => $model->study_program_id, 'curriculum_year_id' => $model->curriculum_year_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<h1><?= Html::encode($this->title) ?></h1><?= $this->render('_form', compact('model', 'subjects')) ?>
