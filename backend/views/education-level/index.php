<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Master Jenjang Pendidikan';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'kartik\grid\SerialColumn', 'width' => '30px'],
    ['attribute' => 'level', 'width' => '140px', 'format' => 'raw', 'value' => static fn ($model) => Html::tag('code', $model->level)],
    ['attribute' => 'name', 'width' => '270px', 'format' => 'raw', 'value' => static fn ($model) => Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'text-decoration-none', 'data-pjax' => 0])],
    ['attribute' => 'sort_order', 'width' => '180px', 'hAlign' => 'right'],
    ['attribute' => 'is_university', 'label' => 'Perguruan Tinggi?', 'format' => 'boolean', 'width' => '145px', 'filter' => [1 => 'Ya', 0 => 'Tidak']],
    ['class' => 'kartik\grid\ActionColumn', 'width' => '125px', 'template' => '{view} {update} {delete}', 'buttons' => [
        'view' => static fn ($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Lihat', 'data-pjax' => 0]),
        'update' => static fn ($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Edit', 'data-pjax' => 0]),
        'delete' => static fn ($url) => Html::a('<i class="fas fa-trash"></i>', $url, ['class' => 'btn btn-sm btn-outline-danger', 'title' => 'Hapus', 'data' => ['confirm' => 'Hapus jenjang pendidikan ini?', 'method' => 'post']]),
    ]],
];
?>

<div class="container-fluid">
    <?= GridView::widget([
        'id' => 'education-level-grid', 'dataProvider' => $dataProvider, 'filterModel' => $searchModel, 'columns' => $columns,
        'pjax' => false, 'responsive' => false, 'bordered' => true, 'striped' => true, 'condensed' => true, 'hover' => true,
        'panel' => ['heading' => '<i class="fas fa-level-up-alt"></i> Master Jenjang Pendidikan', 'type' => GridView::TYPE_DARK],
        'toolbar' => [[
            'content' => Html::a('<i class="fas fa-plus mr-1"></i>', ['create'], ['class' => 'btn btn-md btn-success', 'title' => 'Tambah Jenjang Pendidikan', 'data-pjax' => 0, 'onclick' => 'return event.stopPropagation();']) . ' ' . Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary', 'title' => 'Reset Grid', 'data-pjax' => 0]),
            'options' => ['class' => 'btn-group mr-2'],
        ], '{export}', '{toggleData}'],
        'export' => ['showConfirmAlert' => false, 'target' => GridView::TARGET_BLANK],
        'exportConfig' => [GridView::EXCEL => ['label' => 'Excel', 'filename' => 'Master-Jenjang-Pendidikan-' . date('Ymd')], GridView::CSV => ['label' => 'CSV', 'filename' => 'Master-Jenjang-Pendidikan-' . date('Ymd')]],
    ]) ?>
</div>
