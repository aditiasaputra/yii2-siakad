<?php
use common\models\Region;
use kartik\detail\DetailView;
use yii\helpers\Html;
$label = Region::levelLabels()[$model->level];
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Wilayah Indonesia', 'url' => ['index', '#' => $model->level]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="region-view"><div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><div><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Wilayah Indonesia', ['index', '#' => $model->level], ['class' => 'btn btn-outline-secondary']) ?> <?= Html::a('<i class="fas fa-edit"></i> Ubah', ['update', 'kode' => $model->kode], ['class' => 'btn btn-warning ml-2']) ?> <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'kode' => $model->kode], ['class' => 'btn btn-danger ml-2', 'data' => ['confirm' => 'Hapus wilayah ini?', 'method' => 'post']]) ?></div></div><?= DetailView::widget(['model' => $model, 'panel' => ['heading' => '<i class="fas fa-map-marker-alt"></i> Detail ' . $label, 'type' => DetailView::TYPE_PRIMARY], 'attributes' => ['kode', 'name', ['label' => 'Tingkat', 'value' => $label], ['label' => 'Wilayah Induk', 'value' => $model->parent ? $model->parent->kode . ' - ' . $model->parent->name : '-']]]) ?></div>
