<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model app\models\Faculty */

$this->title = $model->unit_name;
$this->params['breadcrumbs'][] = ['label' => 'Manajemen Fakultas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

// Register JS for toggle status
$this->registerJs("
    $('#toggle-status-btn').on('click', function(e) {
        e.preventDefault();
        var btn = $(this);
        var url = btn.data('url');
        
        $.post(url, function(data) {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        }).fail(function() {
            alert('Terjadi kesalahan saat mengubah status.');
        });
    });
");
?>

<div class="faculty-view">
    <div class="d-flex justify-content-end mb-4">
        <?= Html::button('<i class="fas fa-toggle-' . ($model->is_active ? 'on' : 'off') . '"></i> ' . 
            ($model->is_active ? 'Nonaktifkan' : 'Aktifkan'), [
            'class' => 'btn btn-' . ($model->is_active ? 'dark' : 'success'),
            'id' => 'toggle-status-btn',
            'data-url' => \yii\helpers\Url::to(['toggle-status', 'id' => $model->id]),
        ]) ?>
        
        <?= Html::a('<i class="fas fa-edit"></i> Edit', ['update', 'id' => $model->id], [
            'class' => 'btn btn-warning ml-2'
        ]) ?>
        
        <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger ml-2',
            'data' => [
                'confirm' => 'Apakah Anda yakin ingin menghapus fakultas ini?',
                'method' => 'post',
            ],
        ]) ?>
        
        <?= Html::a('<i class="fas fa-arrow-left"></i> Kembali', ['index'], [
            'class' => 'btn btn-outline-secondary ml-2'
        ]) ?>
    </div>

    <?php Pjax::begin(); ?>
    
    <div class="row">
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'condensed' => false,
                'hover' => false,
                'enableEditMode' => false,
                'mode' => DetailView::MODE_VIEW,
                'panel' => [
                    'heading' => '<i class="fas fa-info-circle"></i> Detail Fakultas',
                    'type' => DetailView::TYPE_PRIMARY,
                ],
                'attributes' => [
                    // [
                    //     'attribute' => 'unit_code',
                    //     'label' => 'Kode Unit',
                    //     'value' => function($model) {
                    //         return Html::tag('code', $model->unit_code, ['class' => 'bg-light p-1']);
                    //     },
                    //     'format' => 'raw',
                    // ],
                    [
                        'attribute' => 'unit_code',
                        'label' => 'Status',
                        'value' => $model->getUnitCode(),
                        'format' => 'raw',
                    ],
                    // 'unit_code:text:Kode Fakultas',
                    'unit_name:text:Nama Fakultas',
                    'unit_name_en:text:Nama Fakultas (EN)',
                    'abbreviation:text:Singkatan',
                    'work_unit:text:Unit Kerja',
                    [
                        'attribute' => 'address',
                        'label' => 'Alamat',
                        'value' => $model->address ? nl2br($model->address) : '<i class="text-muted">Tidak ada alamat</i>',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'phone',
                        'label' => 'Telepon',
                        'value' => $model->phone ? Html::a($model->phone, 'tel:' . $model->phone) : '<i class="text-muted">Tidak ada telepon</i>',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'is_active',
                        'label' => 'Status',
                        'value' => $model->getStatusBadge(),
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
        </div>
        
        <div class="col-md-6">
            <?= DetailView::widget([
                'model' => $model,
                'condensed' => false,
                'hover' => false,
                'enableEditMode' => false,
                'mode' => DetailView::MODE_VIEW,
                'panel' => [
                    'heading' => '<i class="fas fa-users"></i> Pimpinan Fakultas',
                    'type' => DetailView::TYPE_INFO,
                ],
                'attributes' => [
                    [
                        'attribute' => 'dean',
                        'label' => 'Dekan',
                        'value' => $model->dean ?: '<i class="text-muted">Belum diisi</i>',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'vice_dean_1',
                        'label' => 'Wakil Dekan 1',
                        'value' => $model->vice_dean_1 ?: '<i class="text-muted">Belum diisi</i>',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'vice_dean_2',
                        'label' => 'Wakil Dekan 2',
                        'value' => $model->vice_dean_2 ?: '<i class="text-muted">Belum diisi</i>',
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'vice_dean_3',
                        'label' => 'Wakil Dekan 3',
                        'value' => $model->vice_dean_3 ?: '<i class="text-muted">Belum diisi</i>',
                        'format' => 'raw',
                    ],
                ],
            ]) ?>
            
            <?= DetailView::widget([
                'model' => $model,
                'condensed' => false,
                'hover' => false,
                'enableEditMode' => false,
                'mode' => DetailView::MODE_VIEW,
                'panel' => [
                    'heading' => '<i class="fas fa-clock"></i> Informasi Sistem',
                    'type' => DetailView::TYPE_DEFAULT,
                ],
                'attributes' => [
                    [
                        'attribute' => 'created_at',
                        'label' => 'Dibuat Pada',
                        'value' => $model->created_at,
                    ],
                    [
                        'attribute' => 'updated_at',
                        'label' => 'Diperbarui Pada',
                        'value' => $model->updated_at,
                    ],
                    // [
                    //     'attribute' => 'created_by.username',
                    //     'label' => 'Dibuat Oleh',
                    //     'value' => $model->created_by,
                    // ],
                    // [
                    //     'attribute' => 'updated_by.username',
                    //     'label' => 'Diperbarui Oleh',
                    //     'value' => $model->updatedBy,
                    // ],
                ],
            ]) ?>
        </div>
    </div>
    
    <?php Pjax::end(); ?>
</div>

<style>
.badge {
    font-size: 0.9em;
    margin-left: 10px;
}

.btn-group .btn {
    margin-left: 5px;
}

.text-muted {
    font-style: italic;
}

code {
    font-size: 0.9em;
}
</style>