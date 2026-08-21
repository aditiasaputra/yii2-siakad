<?php
use kartik\detail\DetailView;
use yii\helpers\Html;
$this->title = 'Slot ' . $model->formattedTime;
$this->params['breadcrumbs'][] = ['label' => 'Slot Waktu', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="time-slot-view"><div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><div><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index'], ['class' => 'btn btn-outline-secondary']) ?> <?= Html::a('<i class="fas fa-edit"></i> Ubah', ['update', 'id' => $model->id], ['class' => 'btn btn-warning ml-2']) ?> <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger ml-2', 'data' => ['confirm' => 'Hapus slot waktu ini?', 'method' => 'post']]) ?></div></div><?= DetailView::widget(['model' => $model, 'mode' => DetailView::MODE_VIEW, 'panel' => ['heading' => '<i class="fas fa-clock"></i> Detail Slot Waktu', 'type' => DetailView::TYPE_PRIMARY], 'attributes' => [['label' => 'Waktu', 'value' => $model->formattedTime], ['label' => 'Kelompok', 'value' => ['morning' => 'Pagi', 'afternoon' => 'Siang', 'evening' => 'Malam'][$model->period]], ['attribute' => 'created_at', 'format' => ['datetime', 'php:d M Y H:i']], ['attribute' => 'updated_at', 'format' => ['datetime', 'php:d M Y H:i']]]]) ?></div>
