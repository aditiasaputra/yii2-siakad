<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Negara';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <?= GridView::widget([
        'id' => 'country-grid', 'dataProvider' => $dataProvider, 'filterModel' => $searchModel,
        'pjax' => false, 'responsive' => false, 'bordered' => true, 'striped' => true, 'condensed' => true, 'hover' => true,
        'panel' => ['heading' => '<i class="fas fa-globe-asia"></i> Daftar Negara', 'type' => GridView::TYPE_DARK],
        'toolbar' => [
            ['content' => Html::a('<i class="fas fa-plus mr-1"></i>', ['create'], ['class' => 'btn btn-md btn-success', 'title' => 'Tambah Negara', 'data-pjax' => 0]) . ' ' . Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary', 'title' => 'Reset Grid', 'data-pjax' => 0]), 'options' => ['class' => 'btn-group mr-2']],
            '{export}', '{toggleData}',
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'width' => '30px'],
            ['attribute' => 'code', 'width' => '180px', 'format' => 'raw', 'value' => static fn($model) => Html::tag('code', $model->code)],
            ['attribute' => 'name', 'format' => 'raw', 'value' => static fn($model) => Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'text-decoration-none', 'data-pjax' => 0])],
            ['class' => 'kartik\grid\ActionColumn', 'width' => '125px', 'template' => '{view} {update} {delete}', 'buttons' => [
                'view' => static fn($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Lihat', 'data-pjax' => 0]),
                'update' => static fn($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Edit', 'data-pjax' => 0]),
                'delete' => static fn($url) => Html::a('<i class="fas fa-trash"></i>', $url, ['class' => 'btn btn-sm btn-outline-danger', 'title' => 'Hapus', 'data' => ['confirm' => 'Hapus negara ini?', 'method' => 'post']]),
            ]],
        ],
        'export' => ['showConfirmAlert' => false, 'target' => GridView::TARGET_BLANK],
        'exportConfig' => [GridView::EXCEL => ['label' => 'Excel', 'filename' => 'Daftar-Negara-' . date('Ymd')]],
    ]) ?>
</div>
