<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Kelas Perkuliahan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <?= GridView::widget([
        'id' => 'course-class-grid', 'dataProvider' => $dataProvider, 'filterModel' => $searchModel,
        'pjax' => true, 'pjaxSettings' => ['neverTimeout' => true, 'options' => ['id' => 'course-class-pjax']], 'responsive' => false, 'bordered' => true, 'striped' => true, 'condensed' => true, 'hover' => true,
        'panel' => ['heading' => '<i class="fas fa-chalkboard"></i> Kelas Perkuliahan', 'type' => GridView::TYPE_DARK],
        'toolbar' => [
            ['content' => Html::a('<i class="fas fa-plus mr-1"></i>', ['create'], ['class' => 'btn btn-md btn-success', 'title' => 'Tambah Kelas Perkuliahan', 'data-pjax' => 0]) . ' ' . Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-outline-secondary', 'title' => 'Reset Grid', 'data-pjax' => 0]), 'options' => ['class' => 'btn-group mr-2']],
            '{export}', '{toggleData}',
        ],
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn', 'width' => '30px'],
            ['attribute' => 'code', 'width' => '180px', 'format' => 'raw', 'value' => static fn($model) => Html::tag('code', $model->code)],
            ['attribute' => 'name', 'format' => 'raw', 'value' => static fn($model) => Html::a(Html::encode($model->name), ['view', 'id' => $model->id], ['class' => 'text-decoration-none', 'data-pjax' => 0])],
            ['class' => 'kartik\grid\ActionColumn', 'width' => '125px', 'template' => '{view} {update} {delete}', 'buttons' => [
                'view' => static fn($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-outline-info', 'title' => 'Lihat', 'data-pjax' => 0]),
                'update' => static fn($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Edit', 'data-pjax' => 0]),
                'delete' => static fn($url) => Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-sm btn-outline-danger js-delete-course-class', 'title' => 'Hapus', 'data-url' => $url]),
            ]],
        ],
        'export' => ['showConfirmAlert' => false, 'target' => GridView::TARGET_BLANK],
        'exportConfig' => [GridView::EXCEL => ['label' => 'Excel', 'filename' => 'Kelas-Perkuliahan-' . date('Ymd')]],
    ]) ?>
</div>
<?php $this->registerJs(<<<'JS'
$(document).on('click', '.js-delete-course-class', function () {
    var button = $(this);
    Swal.fire({title: 'Hapus Kelas Perkuliahan?', text: 'Data yang sudah dihapus tidak dapat dikembalikan.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal', reverseButtons: true}).then(function (result) {
        if (!result.isConfirmed) return;
        $.ajax({url: button.data('url'), type: 'POST', dataType: 'json', data: {_csrf: yii.getCsrfToken()}})
            .done(function (response) {
                if (!response.success) { Swal.fire('Gagal', response.message || 'Data gagal dihapus.', 'error'); return; }
                Swal.fire({title: 'Berhasil', text: response.message, icon: 'success', timer: 1400, showConfirmButton: false});
                $.pjax.reload({container: '#course-class-pjax', timeout: 0});
            })
            .fail(function () { Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus Kelas Perkuliahan.', 'error'); });
    });
});
JS); ?>
