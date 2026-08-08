<?php
use yii\helpers\Html;
$this->title = 'Tambah Program Studi';
$this->params['breadcrumbs'][] = ['label' => 'Master Program Studi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="study-program-create"><div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali', ['index'], ['class' => 'btn btn-outline-secondary']) ?></div><?= $this->render('_form', ['model' => $model]) ?></div>
