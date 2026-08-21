<?php

use yii\helpers\Html;
use common\widgets\Alert;

$this->title = 'Data Mata Kuliah';
$this->params['breadcrumbs'][] = ['label' => 'Mata Kuliah', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->code;
$lecturerNames = array_map(static fn($lecturer) => $lecturer->user ? $lecturer->user->name : 'Dosen #' . $lecturer->id, $model->lecturers);
$show = static fn($value) => $value === null || $value === '' ? '-' : Html::encode($value);
$activeTab = Yii::$app->request->get('tab', 'data');
$documents = [
    'syllabus' => ['label' => 'Silabus Mata Kuliah', 'fileAttribute' => 'syllabus_file', 'uploadAttribute' => 'syllabus_upload'],
    'material-details' => ['label' => 'Rincian Materi', 'fileAttribute' => 'material_details_file', 'uploadAttribute' => 'material_details_upload'],
];
?>
<div class="subject-view">
    <?= Alert::widget() ?>
    <div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="mb-0"><?= Html::encode($this->title) ?></h1><small class="text-muted">Detail Mata Kuliah</small></div><div><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index'], ['class' => 'btn btn-primary']) ?> <?= Html::a('<i class="fas fa-plus"></i> Tambah Baru', ['create'], ['class' => 'btn btn-success']) ?> <?= Html::a('<i class="fas fa-edit"></i> Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?> <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => ['confirm' => 'Hapus mata kuliah ini?', 'method' => 'post']]) ?></div></div>
    <div class="card card-success card-outline"><div class="card-body"><div class="row">
        <div class="col-lg-2 col-md-3"><div class="list-group mb-3"><?= Html::a('Data Mata Kuliah', ['view', 'id' => $model->id, 'tab' => 'data'], ['class' => 'list-group-item list-group-item-action' . ($activeTab === 'data' ? ' active' : '')]) ?><?php foreach ($documents as $key => $document): ?><?= Html::a(Html::encode($document['label']), ['view', 'id' => $model->id, 'tab' => $key], ['class' => 'list-group-item list-group-item-action' . ($activeTab === $key ? ' active' : '')]) ?><?php endforeach; ?></div></div>
        <div class="col-lg-10 col-md-9"><?php if ($activeTab === 'data'): ?><div class="row">
            <div class="col-lg-6"><table class="table table-sm table-borderless">
                <tr><th>Tahun Kurikulum</th><td><?= $show($model->curriculumYear->year) ?></td></tr>
                <tr><th>Kode Mata Kuliah</th><td><?= $show($model->code) ?></td></tr>
                <tr><th>Nama Mata Kuliah</th><td><?= $show($model->name) ?></td></tr>
                <tr><th>Nama Mata Kuliah (EN)</th><td><?= $show($model->name_en) ?></td></tr>
                <tr><th>Jenis Mata Kuliah</th><td><?= $show($model->subjectType->name) ?></td></tr>
                <tr><th>Kelompok Mata Kuliah</th><td><?= $show($model->subjectGroup->name) ?></td></tr>
                <tr><th>SKS</th><td><?= $show($model->credits) ?></td></tr>
                <tr><th>SKS Tatap Muka</th><td><?= $show($model->face_to_face_credits) ?></td></tr>
                <tr><th>SKS Praktikum</th><td><?= $show($model->practicum_credits) ?></td></tr>
                <tr><th>SKS Skills Lab</th><td><?= $show($model->lab_credits) ?></td></tr>
            </table></div>
            <div class="col-lg-6"><table class="table table-sm table-borderless">
                <tr><th>SKS KSK</th><td><?= $show($model->ksk_credits) ?></td></tr>
                <tr><th>SKS PBL</th><td><?= $show($model->pbl_credits) ?></td></tr>
                <tr><th>Unit Pengampu</th><td><?= $show($model->studyProgram->faculty ? $model->studyProgram->faculty->unit_name : '-') ?></td></tr>
                <tr><th>Prodi Pengampu</th><td><?= $show($model->studyProgram->name) ?></td></tr>
                <tr><th>Dosen Pengampu</th><td><?= $show(implode(', ', $lecturerNames)) ?></td></tr>
                <tr><th>MKU</th><td><?= $show($model->mku) ?></td></tr>
                <tr><th>SAP</th><td><?= $show($model->sap) ?></td></tr>
                <tr><th>Silabus</th><td><?= $show($model->syllabus) ?></td></tr>
                <tr><th>Bahan Ajar</th><td><?= $show($model->teaching_material) ?></td></tr>
                <tr><th>Diktat</th><td><?= $show($model->module) ?></td></tr>
            </table></div>
        </div><?php elseif (isset($documents[$activeTab])): ?><?php $document = $documents[$activeTab]; $storedName = $model->{$document['fileAttribute']}; ?>
            <h4><?= Html::encode($document['label']) ?></h4><p class="text-muted">Unggah dokumen PDF, Word, OpenDocument, Excel, atau PowerPoint dengan ukuran maksimal 10 MB.</p>
            <?php if ($storedName): ?><div class="alert alert-info d-flex align-items-center justify-content-between"><div><i class="fas fa-file-alt mr-2"></i><?= Html::encode(preg_replace('/^[^_]+_[^_]+_/', '', $storedName)) ?></div><div><?= Html::a('<i class="fas fa-download"></i> Unduh', ['download-document', 'id' => $model->id, 'type' => $activeTab], ['class' => 'btn btn-sm btn-primary']) ?> <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete-document', 'id' => $model->id, 'type' => $activeTab], ['class' => 'btn btn-sm btn-danger', 'data' => ['method' => 'post', 'confirm' => 'Hapus file ini?']]) ?></div></div><?php else: ?><div class="alert alert-secondary">Belum ada file yang diunggah.</div><?php endif; ?>
            <?= Html::beginForm(['upload-document', 'id' => $model->id, 'type' => $activeTab], 'post', ['enctype' => 'multipart/form-data']) ?><div class="form-group"><label><?= Html::encode($document['label']) ?></label><?= Html::activeFileInput($model, $document['uploadAttribute'], ['class' => 'form-control-file', 'accept' => '.pdf,.doc,.docx,.odt,.xls,.xlsx,.ppt,.pptx', 'required' => true]) ?></div><?= Html::submitButton('<i class="fas fa-upload"></i> ' . ($storedName ? 'Ganti File' : 'Unggah File'), ['class' => 'btn btn-success']) ?><?= Html::endForm() ?>
        <?php endif; ?></div>
    </div></div></div>
</div>
