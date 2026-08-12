<?php

use common\models\Region;
use kartik\grid\GridView;
use yii\helpers\Html;

$label = Region::levelLabels()[$level];
?>
<?= GridView::widget([
    'id' => 'region-grid-' . $level,
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'pjax' => true,
    'pjaxSettings' => [
        'options' => ['id' => 'region-pjax-' . $level],
        'neverTimeout' => true,
        'enablePushState' => false,
        'enableReplaceState' => false,
    ],
    'responsive' => false,
    'bordered' => true,
    'striped' => true,
    'condensed' => true,
    'hover' => true,
    'panel' => ['heading' => '<i class="fas fa-map-marker-alt"></i> Data ' . Html::encode($label), 'type' => GridView::TYPE_DARK],
    'toolbar' => [
        ['content' => Html::a('<i class="fas fa-plus mr-1"></i>', ['create', 'level' => $level], ['class' => 'btn btn-md btn-success', 'title' => 'Tambah ' . $label, 'data-pjax' => 0]) . ' ' . Html::a('<i class="fas fa-redo"></i>', ['grid', 'level' => $level], ['class' => 'btn btn-outline-secondary', 'title' => 'Reset Grid']), 'options' => ['class' => 'btn-group mr-2']],
        '{export}', '{toggleData}',
    ],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn', 'width' => '30px'],
        ['attribute' => 'kode', 'width' => '180px', 'format' => 'raw', 'value' => static fn($model) => Html::tag('code', $model->kode)],
        ['attribute' => 'name', 'format' => 'raw', 'value' => static fn($model) => Html::a(Html::encode($model->name), ['view', 'kode' => $model->kode], ['class' => 'text-decoration-none', 'data-pjax' => 0])],
        ['attribute' => 'parent_kode', 'label' => 'Wilayah Induk', 'visible' => $level !== 'province', 'value' => static fn($model) => $model->parent ? $model->parent->kode . ' - ' . $model->parent->name : '-'],
        ['class' => 'kartik\grid\ActionColumn', 'width' => '125px', 'template' => '{view} {update} {delete}',
            'urlCreator' => static fn($action, $model) => [$action, 'kode' => $model->kode],
            'buttons' => [
                'view' => static fn($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Lihat', 'data-pjax' => 0]),
                'update' => static fn($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Edit', 'data-pjax' => 0]),
                'delete' => static fn($url) => Html::a('<i class="fas fa-trash"></i>', $url, ['class' => 'btn btn-sm btn-outline-danger', 'title' => 'Hapus', 'data-pjax' => 0, 'data' => ['confirm' => 'Hapus wilayah ini?', 'method' => 'post']]),
            ],
        ],
    ],
    'export' => ['showConfirmAlert' => false, 'target' => GridView::TARGET_BLANK],
    'exportConfig' => [GridView::EXCEL => ['label' => 'Excel', 'filename' => 'Data-' . $label . '-' . date('Ymd')]],
]) ?>
