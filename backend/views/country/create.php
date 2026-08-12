<?php
use yii\helpers\Html;
$this->title = 'Tambah Negara';
$this->params['breadcrumbs'][] = ['label' => 'Negara', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="country-create"><div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index'], ['class' => 'btn btn-outline-secondary']) ?></div><?= $this->render('_form', compact('model')) ?></div>
