<?php
use yii\helpers\Html;
$this->title = 'Edit Program Studi: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Program Studi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="study-program-update"><div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali', ['index'], ['class' => 'btn btn-outline-secondary']) ?></div><?= $this->render('_form', ['model' => $model]) ?></div>
