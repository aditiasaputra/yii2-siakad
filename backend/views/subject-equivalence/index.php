<?php

use common\widgets\Alert;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Ekivalensi Mata Kuliah';
$this->params['breadcrumbs'][] = $this->title;
$indexParams = ['index', 'study_program_id' => $studyProgramId, 'new_curriculum_year_id' => $newYearId, 'old_curriculum_year_id' => $oldYearId];
?>
<?= Alert::widget() ?>
<div class="subject-equivalence-index">
    <div class="d-flex align-items-baseline mb-3"><h1 class="mb-0 mr-2"><?= Html::encode($this->title) ?></h1><span class="text-muted">Padanan Mata Kuliah di Kurikulum Berbeda</span></div>

    <div class="card card-warning card-outline mb-3"><div class="card-body">
        <?= Html::beginForm(['index'], 'get', ['id' => 'equivalence-selector']) ?>
        <div class="row align-items-end">
            <div class="col-lg-4"><label class="text-warning">Prodi</label><?= Select2::widget(['name' => 'study_program_id', 'value' => $studyProgramId, 'data' => $studyPrograms, 'options' => ['id' => 'equivalence-study-program'], 'pluginOptions' => ['allowClear' => false]]) ?></div>
            <div class="col-lg-4"><label class="text-warning">Kurikulum Baru</label><?= Select2::widget(['name' => 'new_curriculum_year_id', 'value' => $newYearId, 'data' => $curriculumYears, 'options' => ['id' => 'equivalence-new-year'], 'pluginOptions' => ['allowClear' => false]]) ?></div>
            <div class="col-lg-4"><label class="text-warning">Kurikulum Lama</label><?= Select2::widget(['name' => 'old_curriculum_year_id', 'value' => $oldYearId, 'data' => $curriculumYears, 'options' => ['id' => 'equivalence-old-year'], 'pluginOptions' => ['allowClear' => false]]) ?></div>
        </div>
        <?= Html::endForm() ?>
    </div></div>

    <?= GridView::widget([
        'id' => 'subject-equivalence-grid',
        'dataProvider' => $dataProvider,
        'pjax' => true,
        'pjaxSettings' => ['neverTimeout' => true, 'options' => ['id' => 'subject-equivalence-pjax']],
        'responsive' => false,
        'bordered' => true,
        'striped' => true,
        'condensed' => true,
        'hover' => true,
        'panel' => [
            'heading' => '<i class="fas fa-exchange-alt mr-1"></i> Daftar Ekivalensi Mata Kuliah',
            'type' => GridView::TYPE_DARK,
            'before' => '<div class="d-flex flex-wrap justify-content-between align-items-center">'
                . Html::beginForm($indexParams, 'get', ['class' => 'form-inline', 'data-pjax' => 1])
                . Html::hiddenInput('study_program_id', $studyProgramId)
                . Html::hiddenInput('new_curriculum_year_id', $newYearId)
                . Html::hiddenInput('old_curriculum_year_id', $oldYearId)
                . '<div class="input-group">' . Html::textInput('q', $q, ['class' => 'form-control', 'placeholder' => 'Cari Ekivalensi Mata Kuliah'])
                . '<div class="input-group-append">' . Html::submitButton('<i class="fas fa-search"></i>', ['class' => 'btn btn-primary', 'title' => 'Cari'])
                . Html::a('<i class="fas fa-sync-alt"></i>', $indexParams, ['class' => 'btn btn-warning', 'title' => 'Reset', 'data-pjax' => 1]) . '</div></div>'
                . Html::endForm() . '</div>',
        ],
        'toolbar' => [
            [
                'content' => Html::a('<i class="fas fa-plus"></i>', ['create', 'study_program_id' => $studyProgramId, 'new_curriculum_year_id' => $newYearId, 'old_curriculum_year_id' => $oldYearId], ['class' => 'btn btn-md btn-success', 'title' => 'Tambah Ekivalensi Mata Kuliah', 'data-pjax' => 0])
                    . Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-md btn-danger js-delete-equivalence', 'title' => 'Hapus Semua Ekivalensi Mata Kuliah', 'data-url' => Url::to(['delete-all', 'study_program_id' => $studyProgramId, 'new_curriculum_year_id' => $newYearId, 'old_curriculum_year_id' => $oldYearId]), 'data-all' => 1]),
                'options' => ['class' => 'btn-group mr-2'],
            ],
        ],
        'columns' => [
            [
                'attribute' => 'new_subject_id', 'label' => 'Mata Kuliah Kurikulum Baru',
                'value' => static fn($entry) => $entry->newSubject->code . ' - ' . $entry->newSubject->name,
            ],
            [
                'attribute' => 'old_subject_id', 'label' => 'Mata Kuliah Kurikulum Lama',
                'value' => static fn($entry) => $entry->oldSubject->code . ' - ' . $entry->oldSubject->name,
            ],
            [
                'class' => 'kartik\grid\ActionColumn', 'header' => 'Aksi', 'width' => '125px', 'template' => '{update} {delete}',
                'urlCreator' => static function ($action, $entry) use ($studyProgramId, $newYearId, $oldYearId) {
                    return $action === 'update'
                        ? Url::to(['update', 'id' => $entry->id])
                        : Url::to(['delete', 'id' => $entry->id]);
                },
                'buttons' => [
                    'update' => static fn($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-primary equivalence-action-button', 'title' => 'Ubah', 'data-pjax' => 0]),
                    'delete' => static fn($url) => Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-sm btn-danger equivalence-action-button js-delete-equivalence', 'title' => 'Hapus', 'data-url' => $url]),
                ],
            ],
        ],
        'emptyText' => 'Data ekivalensi belum tersedia.',
        'summary' => 'Menampilkan <b>{begin}-{end}</b> dari <b>{totalCount}</b> data.',
    ]) ?>
</div>
<?php $this->registerCss('.equivalence-action-button{width:31px;height:31px;padding:0;display:inline-flex;align-items:center;justify-content:center}'); ?>

<?php $this->registerJs(<<<'JS'
$('#equivalence-selector select').on('change', function () {
    var $form = $('#equivalence-selector');
    $.pjax.reload({
        container: '#subject-equivalence-pjax',
        url: $form.attr('action') + '?' + $form.serialize(),
        push: true,
        replace: false,
        timeout: 0
    });
});
JS); ?>
<?php $this->registerJs(<<<'JS'
$(document).on('click', '.js-delete-equivalence', function () {
    var $button = $(this);
    var deleteAll = $button.data('all') == 1;
    Swal.fire({
        title: deleteAll ? 'Hapus Semua Ekivalensi?' : 'Hapus Ekivalensi Mata Kuliah?',
        text: deleteAll ? 'Seluruh ekivalensi pada pilihan kurikulum ini akan dihapus.' : 'Data yang sudah dihapus tidak dapat dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        reverseButtons: true
    }).then(function (result) {
        if (!result.isConfirmed) return;
        $.ajax({url: $button.data('url'), type: 'POST', dataType: 'json', data: {_csrf: yii.getCsrfToken()}})
            .done(function (response) {
                if (!response.success) { Swal.fire('Gagal', response.message || 'Data gagal dihapus.', 'error'); return; }
                Swal.fire({title: 'Berhasil', text: response.message, icon: 'success', timer: 1400, showConfirmButton: false});
                $.pjax.reload({container: '#subject-equivalence-pjax', timeout: 0});
            })
            .fail(function (xhr) {
                var message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan saat menghapus data.';
                Swal.fire('Gagal', message, 'error');
            });
    });
});
JS); ?>
