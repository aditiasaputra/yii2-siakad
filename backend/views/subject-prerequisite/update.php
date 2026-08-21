<?php
use yii\helpers\Html;
$this->title = 'Ubah Prasyarat Mata Kuliah';
$this->params['breadcrumbs'][] = ['label' => 'Prasyarat Mata Kuliah', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Ubah';
?>
<h1><?= Html::encode($this->title) ?></h1><?= $this->render('_form', compact('model', 'curriculumOptions')) ?>
