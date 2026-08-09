<?php

use backend\models\StudyProgram;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Master Ruang Kuliah';
$this->params['breadcrumbs'][] = $this->title;
$programs = ArrayHelper::map(StudyProgram::find()->orderBy('name')->all(), 'id', 'name');
?>
<div class="container-fluid">
    <?= GridView::widget([
        'id' => 'lecture-room-grid',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => false,
        'responsive' => false,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'hover' => true,
        'panel' => ['heading' => '<i class="fas fa-door-open"></i> Master Ruang Kuliah', 'type' => GridView::TYPE_DARK],
        'toolbar' => [[
            'content' => Html::a('<i class="fas fa-plus mr-1"></i>', ['create'], ['class' => 'btn btn-md btn-success', 'title' => 'Tambah Ruang Kuliah', 'data-pjax' => 0]) . ' ' . Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary', 'title' => 'Reset Grid', 'data-pjax' => 0]),
            'options' => ['class' => 'btn-group mr-2'],
        ], '{export}', '{toggleData}'],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'width' => '30px'],
            ['attribute' => 'code', 'width' => '110px', 'format' => 'raw', 'value' => static fn($model) => Html::tag('code', $model->code)],
            ['attribute' => 'name', 'label' => 'Nama Ruang', 'width' => '230px', 'format' => 'raw', 'value' => static fn($model) => Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'text-decoration-none', 'data-pjax' => 0])],
            ['attribute' => 'study_program_id', 'label' => 'Unit', 'width' => '280px', 'filter' => $programs, 'value' => static fn($model) => $model->studyProgram ? $model->studyProgram->name : '-'],
            ['attribute' => 'location', 'width' => '160px'],
            ['attribute' => 'capacity', 'label' => 'Kap.', 'width' => '90px', 'hAlign' => 'right'],
            ['attribute' => 'is_active', 'label' => 'Aktif', 'format' => 'boolean', 'width' => '90px', 'filter' => [1 => 'Ya', 0 => 'Tidak']],
            ['class' => 'kartik\grid\ActionColumn', 'width' => '125px', 'template' => '{view} {update} {delete}', 'buttons' => [
                'view' => static fn($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Lihat', 'data-pjax' => 0]),
                'update' => static fn($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Edit', 'data-pjax' => 0]),
                'delete' => static fn($url) => Html::a('<i class="fas fa-trash"></i>', $url, ['class' => 'btn btn-sm btn-outline-danger', 'title' => 'Hapus', 'data' => ['confirm' => 'Hapus ruang kuliah ini?', 'method' => 'post']]),
            ]],
        ],
        'export' => ['showConfirmAlert' => false, 'target' => GridView::TARGET_BLANK],
        'exportConfig' => [GridView::EXCEL => ['label' => 'Excel', 'filename' => 'Master-Ruang-Kuliah-' . date('Ymd')]],
    ]) ?>
</div>
