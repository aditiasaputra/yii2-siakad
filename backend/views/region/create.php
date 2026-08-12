<?php
use common\models\Region;
use yii\helpers\Html;
$this->title = 'Tambah ' . Region::levelLabels()[$level];
$this->params['breadcrumbs'][] = ['label' => 'Wilayah Indonesia', 'url' => ['index', '#' => $level]];
$this->params['breadcrumbs'][] = 'Tambah';
?>
<div class="region-create"><div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Wilayah Indonesia', ['index', '#' => $level], ['class' => 'btn btn-outline-secondary']) ?></div><?= $this->render('_form', compact('model', 'level')) ?></div>
