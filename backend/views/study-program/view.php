<?php

use kartik\detail\DetailView;
use yii\helpers\Html;

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Program Studi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="study-program-view">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index'], ['class' => 'btn btn-outline-secondary']) ?>
            <?= Html::a('<i class="fas fa-edit"></i> Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-warning ml-2']) ?>
            <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger ml-2', 'data' => ['confirm' => 'Hapus program studi ini?', 'method' => 'post']]) ?>
        </div>
    </div>

    <?= DetailView::widget([
        'model' => $model,
        'mode' => DetailView::MODE_VIEW,
        'panel' => ['heading' => '<i class="fas fa-graduation-cap"></i> Detail Program Studi', 'type' => DetailView::TYPE_PRIMARY],
        'attributes' => [
            'code', 'name', 'short_name', 'name_en',
            ['attribute' => 'faculty_id', 'value' => $model->faculty ? $model->faculty->unit_name : '-'],
            'program_type', 'work_unit', 'phone', 'address:ntext',
            ['attribute' => 'is_active', 'value' => $model->is_active ? 'Aktif' : 'Nonaktif'],
            'head_of_program', 'secretary_of_program', 'nim_prefix', 'minimum_graduation_credits',
            'minimum_graduation_gpa', 'degree', 'degree_abbreviation', 'grade',
            ['attribute' => 'created_at', 'format' => ['datetime', 'php:d M Y H:i']],
            ['attribute' => 'updated_at', 'format' => ['datetime', 'php:d M Y H:i']],
        ],
    ]) ?>
</div>
