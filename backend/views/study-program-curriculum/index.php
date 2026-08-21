<?php

use common\widgets\Alert;
use yii\helpers\Html;

$this->title = 'Kurikulum Prodi';
$this->params['breadcrumbs'][] = $this->title;
$semesters = array_keys($bySemester);
if (!$semesters) { $semesters = [1, 2]; }
if (count($semesters) % 2) { $semesters[] = max($semesters) + 1; }
?>
<?= Alert::widget() ?>
<div class="d-flex justify-content-between align-items-center mb-3"><div class="d-flex align-items-baseline"><h1 class="mb-0 mr-2"><?= Html::encode($this->title) ?></h1><span class="text-muted">Kurikulum Prodi Per Semester</span></div><?= Html::a('<i class="fas fa-plus mr-1"></i> Tambah Kurikulum Prodi', ['create', 'study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId], ['class' => 'btn btn-success']) ?></div>
<div class="card card-warning card-outline"><div class="card-body">
    <div class="row align-items-center">
        <div class="col-lg-7"><?= Html::beginForm(['index'], 'get', ['id' => 'curriculum-selector']) ?><div class="form-row align-items-center"><div class="col-md-2"><strong class="text-warning">Prodi</strong></div><div class="col-md-5"><?= Html::dropDownList('study_program_id', $studyProgramId, $studyPrograms, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) ?></div><div class="col-md-2"><strong class="text-warning">Kurikulum</strong></div><div class="col-md-3"><?= Html::dropDownList('curriculum_year_id', $curriculumYearId, $curriculumYears, ['class' => 'form-control', 'onchange' => 'this.form.submit()']) ?></div></div><?= Html::endForm() ?></div>
        <div class="col-lg-3"><?= Html::beginForm(['copy', 'study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId], 'post', ['id' => 'copy-curriculum-form']) ?><div class="input-group"><?= Html::dropDownList('target_curriculum_year_id', null, array_diff_key($curriculumYears, [$curriculumYearId => true]), ['class' => 'form-control', 'prompt' => 'Salin ke...', 'required' => true]) ?><div class="input-group-append"><?= Html::submitButton('<i class="fas fa-copy"></i> Salin', ['class' => 'btn btn-warning', 'id' => 'copy-curriculum-button']) ?></div></div><?= Html::endForm() ?></div>
        <div class="col-lg-2"><?= Html::a('<i class="fas fa-file-pdf"></i> Cetak Silabus', ['print-syllabus', 'study_program_id' => $studyProgramId, 'curriculum_year_id' => $curriculumYearId], ['class' => 'btn btn-primary', 'target' => '_blank']) ?></div>
    </div>
</div></div>
<div class="card card-success card-outline"><div class="card-body"><div class="row">
    <?php foreach ($semesters as $semester): ?><div class="col-lg-6 mb-4"><?= $this->render('_semester_table', ['semester' => $semester, 'entries' => $bySemester[$semester] ?? []]) ?></div><?php endforeach; ?>
</div></div></div>
<?php
$this->registerJs(<<<JS
$('#copy-curriculum-form').on('submit', function (event) {
    event.preventDefault();
    var form = $(this);
    var button = $('#copy-curriculum-button');
    Swal.fire({title: 'Salin Kurikulum Prodi?', text: 'Seluruh data akan disalin ke tahun kurikulum tujuan.', icon: 'warning', showCancelButton: true, confirmButtonText: 'Ya, Salin', cancelButtonText: 'Batal', reverseButtons: true}).then(function (result) {
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
                var message = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Terjadi kesalahan saat menyalin Kurikulum Prodi.';
                Swal.fire({title: 'Gagal', text: message, icon: 'error'});
            })
            .always(function () { button.prop('disabled', false).html('<i class="fas fa-copy"></i> Salin'); });
    });
});
$(document).on('click', '.js-delete-curriculum', function () {
    var button = $(this);
    Swal.fire({title: 'Hapus Data Kurikulum Prodi?', text: 'Data yang sudah dihapus tidak dapat dikembalikan.', icon: 'warning', showCancelButton: true, confirmButtonColor: '#dc3545', confirmButtonText: 'Ya, Hapus', cancelButtonText: 'Batal', reverseButtons: true}).then(function (result) {
        if (!result.isConfirmed) return;
        $.ajax({url: button.data('url'), type: 'POST', dataType: 'json', data: {_csrf: yii.getCsrfToken()}})
            .done(function (response) { if (response.success) { Swal.fire({title: 'Berhasil', text: response.message, icon: 'success'}).then(function () { window.location.reload(); }); } else { Swal.fire('Gagal', response.message || 'Data gagal dihapus.', 'error'); } })
            .fail(function () { Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus data.', 'error'); });
    });
});
JS);
?>
