<?php
use backend\models\StudyProgram;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = 'Master Konsentrasi'; $this->params['breadcrumbs'][] = $this->title;
$programs = ArrayHelper::map(StudyProgram::find()->orderBy('name')->all(), 'id', 'name');
$columns = [
    ['class' => 'kartik\grid\SerialColumn', 'width' => '30px'],
    ['attribute' => 'study_program_id', 'label' => 'Program Studi', 'width' => '220px', 'filter' => $programs, 'value' => static fn($model) => $model->studyProgram->name],
    ['attribute' => 'code', 'width' => '110px', 'format' => 'raw', 'value' => static fn($model) => Html::tag('code', $model->code)],
    ['attribute' => 'name', 'width' => '280px', 'format' => 'raw', 'value' => static fn($model) => Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'text-decoration-none', 'data-pjax' => 0])],
    ['attribute' => 'name_en', 'label' => 'Nama Konsentrasi (EN)', 'width' => '280px'],
    ['class' => 'kartik\grid\ActionColumn', 'width' => '125px', 'template' => '{view} {update} {delete}', 'buttons' => ['view' => static fn($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Lihat', 'data-pjax' => 0]), 'update' => static fn($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Edit', 'data-pjax' => 0]), 'delete' => static fn($url) => Html::a('<i class="fas fa-trash"></i>', $url, ['class' => 'btn btn-sm btn-outline-danger', 'title' => 'Hapus', 'data' => ['confirm' => 'Hapus konsentrasi ini?', 'method' => 'post']])]],
];
?>
<div class="container-fluid"><?= GridView::widget(['id' => 'concentration-grid', 'dataProvider' => $dataProvider, 'filterModel' => $searchModel, 'columns' => $columns, 'pjax' => true, 'responsive' => false, 'bordered' => true, 'striped' => true, 'condensed' => true, 'hover' => true, 'panel' => ['heading' => '<i class="fas fa-sitemap"></i> Master Konsentrasi', 'type' => GridView::TYPE_DARK], 'toolbar' => [['content' => Html::a('<i class="fas fa-plus mr-1"></i>', ['create'], ['class' => 'btn btn-md btn-success', 'title' => 'Tambah Konsentrasi', 'data-pjax' => 0, 'onclick' => 'return event.stopPropagation();']) . ' ' . Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary', 'title' => 'Reset Grid', 'data-pjax' => 0]), 'options' => ['class' => 'btn-group mr-2']], '{export}', '{toggleData}'], 'export' => ['showConfirmAlert' => false, 'target' => GridView::TARGET_BLANK], 'exportConfig' => [GridView::EXCEL => ['label' => 'Excel', 'filename' => 'Master-Konsentrasi-' . date('Ymd')], GridView::CSV => ['label' => 'CSV', 'filename' => 'Master-Konsentrasi-' . date('Ymd')]]]) ?></div>
