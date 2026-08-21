<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Status Hadir';
$this->params['breadcrumbs'][] = $this->title;
$booleanFilter = ['0' => 'Tidak', '1' => 'Ya'];
$booleanValue = static fn($value) => $value
    ? '<span class="text-success"><i class="fas fa-check"></i></span>'
    : '<span class="text-danger"><i class="fas fa-times"></i></span>';
?>
<div class="container-fluid">
    <?= GridView::widget([
        'id' => 'attendance-status-grid', 'dataProvider' => $dataProvider, 'filterModel' => $searchModel,
        'pjax' => false, 'responsive' => true, 'bordered' => true, 'striped' => true, 'condensed' => true, 'hover' => true,
        'panel' => ['heading' => '<i class="fas fa-user-check"></i> Status Hadir', 'type' => GridView::TYPE_DARK],
        'toolbar' => [
            ['content' => Html::a('<i class="fas fa-plus mr-1"></i>', ['create'], ['class' => 'btn btn-md btn-success', 'title' => 'Tambah Status Hadir', 'data-pjax' => 0]) . ' ' . Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary', 'title' => 'Reset Grid', 'data-pjax' => 0]), 'options' => ['class' => 'btn-group mr-2']],
            '{export}', '{toggleData}',
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'width' => '30px'],
            ['attribute' => 'code', 'width' => '100px', 'format' => 'raw', 'value' => static fn($model) => Html::tag('code', $model->code)],
            ['attribute' => 'name', 'format' => 'raw', 'value' => static fn($model) => Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'text-decoration-none', 'data-pjax' => 0])],
            ['attribute' => 'counts_as_present', 'format' => 'raw', 'filter' => $booleanFilter, 'hAlign' => GridView::ALIGN_CENTER, 'value' => static fn($model) => $booleanValue($model->counts_as_present)],
            ['attribute' => 'applies_to_lecturers', 'format' => 'raw', 'filter' => $booleanFilter, 'hAlign' => GridView::ALIGN_CENTER, 'value' => static fn($model) => $booleanValue($model->applies_to_lecturers)],
            ['attribute' => 'applies_to_students', 'format' => 'raw', 'filter' => $booleanFilter, 'hAlign' => GridView::ALIGN_CENTER, 'value' => static fn($model) => $booleanValue($model->applies_to_students)],
            ['class' => 'kartik\grid\ActionColumn', 'width' => '125px', 'template' => '{view} {update} {delete}', 'buttons' => [
                'view' => static fn($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Lihat', 'data-pjax' => 0]),
                'update' => static fn($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Edit', 'data-pjax' => 0]),
                'delete' => static fn($url) => Html::a('<i class="fas fa-trash"></i>', $url, ['class' => 'btn btn-sm btn-outline-danger', 'title' => 'Hapus', 'data' => ['confirm' => 'Hapus status hadir ini?', 'method' => 'post']]),
            ]],
        ],
        'export' => ['showConfirmAlert' => false, 'target' => GridView::TARGET_BLANK],
        'exportConfig' => [GridView::EXCEL => ['label' => 'Excel', 'filename' => 'Status-Hadir-' . date('Ymd')]],
    ]) ?>
</div>
