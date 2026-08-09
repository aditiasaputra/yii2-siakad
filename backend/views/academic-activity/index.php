<?php
use kartik\grid\GridView;
use yii\helpers\Html;
$this->title = 'Master Kegiatan Akademik'; $this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid"><?= GridView::widget([
    'id' => 'academic-activity-grid', 'dataProvider' => $dataProvider, 'filterModel' => $searchModel, 'pjax' => false, 'responsive' => false, 'bordered' => true, 'striped' => true, 'condensed' => true, 'hover' => true,
    'panel' => ['heading' => '<i class="fas fa-calendar-alt"></i> Master Kegiatan Akademik', 'type' => GridView::TYPE_DARK],
    'toolbar' => [['content' => Html::a('<i class="fas fa-plus mr-1"></i>', ['create'], ['class' => 'btn btn-md btn-success', 'title' => 'Tambah Kegiatan Akademik', 'data-pjax' => 0]) . ' ' . Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary', 'title' => 'Reset Grid']), 'options' => ['class' => 'btn-group mr-2']], '{export}', '{toggleData}'],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn', 'width' => '30px'],
        ['attribute' => 'code', 'width' => '120px', 'format' => 'raw', 'value' => static fn($model) => Html::tag('code', $model->code)],
        ['attribute' => 'name', 'label' => 'Nama Kegiatan Akademik', 'width' => '350px', 'format' => 'raw', 'value' => static fn($model) => Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'text-decoration-none'])],
        ['attribute' => 'background', 'width' => '180px', 'format' => 'raw', 'value' => static fn($model) => $model->background ? Html::tag('span', Html::encode($model->background), ['class' => 'badge', 'style' => 'background:' . Html::encode($model->background) . '; color:#fff; padding:.45rem .7rem;']) : '-'],
        ['class' => 'kartik\grid\ActionColumn', 'width' => '125px', 'template' => '{view} {update} {delete}', 'buttons' => ['view' => static fn($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-outline-info']), 'update' => static fn($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-outline-warning']), 'delete' => static fn($url) => Html::a('<i class="fas fa-trash"></i>', $url, ['class' => 'btn btn-sm btn-outline-danger', 'data' => ['confirm' => 'Hapus kegiatan akademik ini?', 'method' => 'post']])]],
    ], 'export' => ['showConfirmAlert' => false, 'target' => GridView::TARGET_BLANK],
]) ?></div>
