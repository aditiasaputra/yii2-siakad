<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Master Program Studi';
$this->params['breadcrumbs'][] = $this->title;

$columns = [
    ['class' => 'kartik\grid\SerialColumn', 'width' => '30px'],
    ['attribute' => 'code', 'width' => '105px', 'format' => 'raw', 'value' => static fn ($model) => Html::tag('code', $model->code)],
    ['attribute' => 'name', 'label' => 'Nama Program Studi', 'width' => '240px', 'format' => 'raw', 'value' => static fn ($model) => Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'text-decoration-none', 'data-pjax' => 0])],
    ['attribute' => 'short_name', 'width' => '115px'],
    ['attribute' => 'faculty_name', 'label' => 'Fakultas', 'width' => '180px', 'value' => static fn ($model) => $model->faculty ? $model->faculty->unit_name : '-'],
    ['attribute' => 'program_type', 'label' => 'Tk. Pendidikan', 'width' => '115px'],
    ['attribute' => 'work_unit', 'width' => '170px'],
    ['attribute' => 'phone', 'width' => '120px'],
    ['attribute' => 'grade', 'label' => 'Akreditasi', 'width' => '100px'],
    ['attribute' => 'is_active', 'width' => '85px', 'format' => 'raw', 'filter' => [1 => 'Aktif', 0 => 'Nonaktif'], 'value' => static fn ($model) => Html::a($model->getStatusBadge(), ['toggle-status', 'id' => $model->id], ['class' => 'toggle-status'])],
    ['class' => 'kartik\grid\ActionColumn', 'width' => '125px', 'template' => '{view} {update} {delete}', 'buttons' => [
        'view' => static fn ($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Lihat', 'data-pjax' => 0]),
        'update' => static fn ($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Edit', 'data-pjax' => 0]),
        'delete' => static fn ($url) => Html::a('<i class="fas fa-trash"></i>', $url, ['class' => 'btn btn-sm btn-outline-danger', 'title' => 'Hapus', 'data' => ['confirm' => 'Hapus program studi ini?', 'method' => 'post']]),
    ]],
];
?>

<div class="container-fluid">
    <?= GridView::widget([
        'id' => 'study-program-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
        'pjax' => false,
        'responsive' => false,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'hover' => true,
        'panel' => ['heading' => '<i class="fas fa-graduation-cap"></i> Master Program Studi', 'type' => GridView::TYPE_DARK],
        'toolbar' => [[
            'content' => Html::a('<i class="fas fa-plus mr-1"></i>', ['create'], [
                'class' => 'btn btn-md btn-success',
                'title' => 'Tambah Program Studi',
                'data-pjax' => 0,
                'onclick' => 'return event.stopPropagation();',
            ]) . ' ' . Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary', 'title' => 'Reset Grid', 'data-pjax' => 0]),
            'options' => ['class' => 'btn-group mr-2'],
        ], '{export}', '{toggleData}'],
        'export' => ['showConfirmAlert' => false, 'target' => GridView::TARGET_BLANK],
        'exportConfig' => [GridView::EXCEL => ['label' => 'Excel', 'filename' => 'Master-Program-Studi-' . date('Ymd')], GridView::CSV => ['label' => 'CSV', 'filename' => 'Master-Program-Studi-' . date('Ymd')]],
    ]) ?>
</div>

<?php
$this->registerJs("$(document).on('click', '.toggle-status', function (event) { event.preventDefault(); $.post($(this).attr('href'), function () { $.pjax.reload({container: '#study-program-grid-pjax'}); }); });");
?>
