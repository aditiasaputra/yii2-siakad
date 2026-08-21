<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Data Kurikulum';
$this->params['breadcrumbs'][] = ['label' => 'Kurikulum Prodi', 'url' => ['index', 'study_program_id' => $model->study_program_id, 'curriculum_year_id' => $model->curriculum_year_id]];
$this->params['breadcrumbs'][] = $this->title;
$show = static fn($value) => $value === null || $value === '' ? '-' : Html::encode($value);
?>
<div class="study-program-curriculum-view">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="mb-0"><?= Html::encode($this->title) ?></h1><small class="text-muted">Mata Kuliah Kurikulum Prodi</small></div><div><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index', 'study_program_id' => $model->study_program_id, 'curriculum_year_id' => $model->curriculum_year_id], ['class' => 'btn btn-primary']) ?> <?= Html::a('<i class="fas fa-plus"></i> Tambah Baru', ['create', 'study_program_id' => $model->study_program_id, 'curriculum_year_id' => $model->curriculum_year_id], ['class' => 'btn btn-success']) ?> <?= Html::a('<i class="fas fa-edit"></i> Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?> <?= Html::button('<i class="fas fa-trash"></i> Hapus', ['class' => 'btn btn-danger js-delete-detail', 'data-url' => Url::to(['delete', 'id' => $model->id])]) ?></div></div>
    <div class="card card-success card-outline"><div class="card-body"><div class="row">
        <div class="col-lg-2 col-md-3"><div class="list-group"><span class="list-group-item active">Data Kurikulum Prodi</span><span class="list-group-item text-muted">Setting Konsentrasi</span><span class="list-group-item text-muted">Satuan Acara Perkuliahan (SAP)</span></div></div>
        <div class="col-lg-10 col-md-9"><div class="row"><div class="col-md-6"><table class="table table-sm table-borderless">
            <tr><th>Tahun Kurikulum</th><td><?= $show($model->curriculumYear->year) ?></td></tr><tr><th>Program Studi</th><td><?= $show($model->studyProgram->name) ?></td></tr>
            <tr><th>Kode Mata Kuliah</th><td><?= $show($model->subject->code) ?></td></tr><tr><th>Nama Mata Kuliah</th><td><?= $show($model->subject->name) ?></td></tr>
            <tr><th>SKS</th><td><?= $show($model->subject->credits) ?></td></tr><tr><th>Semester</th><td><?= $show($model->semester) ?></td></tr>
        </table></div><div class="col-md-6"><table class="table table-sm table-borderless">
            <tr><th>Wajib/Pilihan</th><td><?= $model->is_mandatory ? 'Wajib' : 'Pilihan' ?></td></tr><tr><th>Paket</th><td><?= $model->is_package ? '<span class="text-success"><i class="fas fa-check"></i> Termasuk paket</span>' : 'Tidak termasuk paket' ?></td></tr>
            <tr><th>Nilai Min</th><td><?= $show($model->minimum_grade) ?></td></tr><tr><th>Topik</th><td><?= $show($model->topic) ?></td></tr>
            <tr><th>Kompetensi Dasar</th><td><?= $show($model->basic_competencies) ?></td></tr><tr><th>SKS Minimal</th><td><?= $show($model->minimum_credits) ?></td></tr>
        </table></div></div></div>
    </div></div></div>
</div>
<?php $redirectUrl = Url::to(['index', 'study_program_id' => $model->study_program_id, 'curriculum_year_id' => $model->curriculum_year_id]); $this->registerJs("$('.js-delete-detail').on('click',function(){var url=$(this).data('url');Swal.fire({title:'Hapus Data Kurikulum Prodi?',text:'Data yang sudah dihapus tidak dapat dikembalikan.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc3545',confirmButtonText:'Ya, Hapus',cancelButtonText:'Batal',reverseButtons:true}).then(function(result){if(!result.isConfirmed)return;$.ajax({url:url,type:'POST',dataType:'json',data:{_csrf:yii.getCsrfToken()}}).done(function(response){if(response.success){Swal.fire('Berhasil',response.message,'success').then(function(){window.location.href='" . $redirectUrl . "';});}else{Swal.fire('Gagal',response.message||'Data gagal dihapus.','error');}}).fail(function(){Swal.fire('Gagal','Terjadi kesalahan saat menghapus data.','error');});});});"); ?>
