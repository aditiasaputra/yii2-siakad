<?php
use kartik\detail\DetailView;
use yii\helpers\Html;
$this->title = 'Kurikulum ' . $model->year;
$this->params['breadcrumbs'][] = ['label' => 'Tahun Kurikulum', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="curriculum-year-view"><div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><div><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index'], ['class' => 'btn btn-outline-secondary']) ?> <?= Html::a('<i class="fas fa-edit"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-warning ml-2']) ?> <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger ml-2', 'data' => ['confirm' => 'Hapus tahun kurikulum ini?', 'method' => 'post']]) ?></div></div><?= DetailView::widget(['model' => $model, 'mode' => DetailView::MODE_VIEW, 'panel' => ['heading' => '<i class="fas fa-calendar-alt"></i> Detail Tahun Kurikulum', 'type' => DetailView::TYPE_PRIMARY], 'attributes' => ['year', 'description', ['attribute' => 'created_at', 'format' => ['datetime', 'php:d M Y H:i']], ['attribute' => 'updated_at', 'format' => ['datetime', 'php:d M Y H:i']]]]) ?></div>
