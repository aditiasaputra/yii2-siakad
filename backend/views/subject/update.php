<?php
use yii\helpers\Html;
$this->title = 'Ubah Mata Kuliah: ' . $model->code;
$this->params['breadcrumbs'][] = ['label' => 'Mata Kuliah', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->code, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<div class="subject-update"><h1><?= Html::encode($this->title) ?></h1><?= $this->render('_form', compact('model', 'curriculumYears', 'subjectTypes', 'subjectGroups', 'studyPrograms', 'lecturers')) ?></div>
