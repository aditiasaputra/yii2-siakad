<?php

use backend\models\SubjectPrerequisite;
use common\widgets\Alert;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Prasyarat Mata Kuliah';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Alert::widget() ?>
<div class="d-flex justify-content-between align-items-center mb-3"><div class="d-flex align-items-baseline"><h1 class="mb-0 mr-2"><?= Html::encode($this->title) ?></h1><span class="text-muted">Prasyarat Mata Kuliah Lulus dan Sedang Ditempuh</span></div><div><?= Html::a('<i class="fas fa-plus mr-1"></i> Tambah Prasyarat', ['create', 'study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId], ['class' => 'btn btn-success']) ?> <?= Html::button('<i class="fas fa-trash mr-1"></i> Hapus Semua', ['class' => 'btn btn-danger js-delete-prerequisite', 'data-url' => Url::to(['delete-all', 'study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId]), 'data-all' => 1]) ?></div></div>
<div class="card card-warning card-outline"><div class="card-body"><div class="row align-items-center">
    <div class="col-lg-7"><?= Html::beginForm(['index'], 'get') ?><div class="form-row align-items-center"><div class="col-md-2"><strong class="text-warning">Prodi</strong></div><div class="col-md-5"><?= Html::dropDownList('study_program_id', $studyProgramId, $studyPrograms, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) ?></div><div class="col-md-2"><strong class="text-warning">Kurikulum</strong></div><div class="col-md-3"><?= Html::dropDownList('curriculum_year_id', $curriculumYearId, $curriculumYears, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) ?></div></div><?= Html::endForm() ?></div>
    <div class="col-lg-5"><?= Html::beginForm(['copy', 'study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId], 'post', ['id' => 'copy-prerequisite-form']) ?><div class="form-row align-items-center"><div class="col-md-3"><strong class="text-warning">Salin Ke</strong></div><div class="col-md-6"><?= Html::dropDownList('target_curriculum_year_id', null, array_diff_key($curriculumYears, [$curriculumYearId => true]), ['class' => 'form-control', 'prompt' => '- Pilih Tujuan -', 'required' => true]) ?></div><div class="col-md-3"><?= Html::submitButton('<i class="fas fa-copy"></i> Salin', ['class' => 'btn btn-warning', 'id' => 'copy-prerequisite-button']) ?></div></div><?= Html::endForm() ?></div>
</div></div></div>
<div class="card card-success card-outline"><div class="card-body"><div class="table-responsive"><table class="table table-bordered table-striped table-hover">
    <thead class="thead-dark"><tr><th rowspan="2" style="width:35px"><input type="checkbox" disabled></th><th colspan="2" class="text-center">Mata Kuliah</th><th colspan="2" class="text-center">Prasyarat</th><th rowspan="2">Jenis</th><th rowspan="2">Nilai Min</th><th rowspan="2" style="width:110px">Aksi</th></tr><tr><th>Kode</th><th>Nama</th><th>Kode</th><th>Nama</th></tr></thead>
    <tbody><?php if (!$entries): ?><tr><td colspan="8" class="text-center text-muted">Belum ada data prasyarat.</td></tr><?php endif; ?><?php foreach ($entries as $entry): ?><tr>
        <td><input type="checkbox" disabled></td><td><?= Html::encode($entry->courseCurriculum->subject->code) ?></td><td><?= Html::a(Html::encode($entry->courseCurriculum->subject->name), ['view', 'id' => $entry->id]) ?></td>
        <td><?= Html::encode($entry->prerequisiteCurriculum->subject->code) ?></td><td><?= Html::encode($entry->prerequisiteCurriculum->subject->name) ?></td><td><?= Html::encode(SubjectPrerequisite::typeOptions()[$entry->requirement_type]) ?></td><td><?= Html::encode($entry->minimum_grade ?: 'Tidak Ada') ?></td>
        <td><?= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $entry->id], ['class' => 'btn btn-sm btn-primary']) ?> <?= Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-sm btn-danger js-delete-prerequisite', 'data-url' => Url::to(['delete', 'id' => $entry->id])]) ?></td>
    </tr><?php endforeach; ?></tbody>
</table></div></div></div>
<?php
$this->registerJs(<<<JS
$('#copy-prerequisite-form').on('submit', function (event) {
    event.preventDefault();
    var form = $(this);
    var button = $('#copy-prerequisite-button');
    Swal.fire({title: 'Salin Prasyarat Mata Kuliah?', text: 'Seluruh relasi prasyarat akan disalin ke kurikulum tujuan.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, Salin', cancelButtonText: 'Batal', reverseButtons: true}).then(function (result) {
        if (!result.isConfirmed) return;
        button.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Menyalin...');
        Swal.fire({title: 'Menyalin Data...', text: 'Mohon tunggu hingga proses selesai.', allowOutsideClick: false, allowEscapeKey: false, didOpen: function () { Swal.showLoading(); }});
        $.ajax({url: form.attr('action'), type: 'POST', data: form.serialize(), dataType: 'json'})
            .done(function (response) {
                if (response.success) {
                    Swal.fire({title: 'Berhasil', text: response.message || 'Data berhasil disalin.', icon: 'success', confirmButtonText: 'OK'}).then(function () {
                        if (response.redirectUrl) window.location.href = response.redirectUrl;
                    });
                    return;
                }
                Swal.fire({title: 'Gagal', text: response.message || 'Data gagal disalin.', icon: 'error'});
            })
            .fail(function (xhr) {
                var message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan saat menyalin Prasyarat Mata Kuliah.';
                Swal.fire({title: 'Gagal', text: message, icon: 'error'});
            })
            .always(function () { button.prop('disabled', false).html('<i class="fas fa-copy"></i> Salin'); });
    });
});
$(document).on('click', '.js-delete-prerequisite', function () {
    var button = $(this), deleteAll = button.data('all') == 1;
    Swal.fire({title: deleteAll ? 'Hapus Semua Prasyarat?' : 'Hapus Prasyarat Mata Kuliah?', text: deleteAll ? 'Seluruh prasyarat pada kurikulum ini akan dihapus.' : 'Data yang sudah dihapus tidak dapat dikembalikan.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal', reverseButtons: true}).then(function (result) {
        if (!result.isConfirmed) return;
        $.ajax({url: button.data('url'), type: 'POST', dataType: 'json', data: {_csrf: yii.getCsrfToken()}})
            .done(function (response) { if (response.success) { Swal.fire({title: 'Berhasil', text: response.message, icon: 'success'}).then(function () { window.location.reload(); }); } else { Swal.fire('Gagal', response.message || 'Data gagal dihapus.', 'error'); } })
            .fail(function () { Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus data.', 'error'); });
    });
});
JS);
?>
