<?php
use yii\helpers\Html;
$this->title = 'Tambah Jabatan Struktural';
$this->params['breadcrumbs'][] = ['label' => 'Jabatan Struktural', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="structural-position-create"><div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index'], ['class' => 'btn btn-outline-secondary']) ?></div><?= $this->render('_form', compact('model')) ?></div>
