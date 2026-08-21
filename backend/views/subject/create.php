<?php
use yii\helpers\Html;
$this->title = 'Tambah Mata Kuliah';
$this->params['breadcrumbs'][] = ['label' => 'Mata Kuliah', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-create"><h1><?= Html::encode($this->title) ?></h1><?= $this->render('_form', compact('model', 'curriculumYears', 'subjectTypes', 'subjectGroups', 'studyPrograms', 'lecturers')) ?></div>
