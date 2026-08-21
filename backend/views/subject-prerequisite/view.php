<?php

use backend\models\SubjectPrerequisite;
use yii\helpers\Html;

$this->title = 'Data Prasyarat Mata Kuliah';
$course = $model->courseCurriculum;
$prerequisite = $model->prerequisiteCurriculum;
$this->params['breadcrumbs'][] = ['label' => 'Prasyarat Mata Kuliah', 'url' => ['index', 'study_program_id' => $course->study_program_id, 'curriculum_year_id' => $course->curriculum_year_id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-prerequisite-view">
    <div class="d-flex justify-content-between align-items-center mb-4"><div><h1 class="mb-0"><?= Html::encode($this->title) ?></h1><small class="text-muted">Detail Prasyarat Mata Kuliah</small></div><div><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index', 'study_program_id' => $course->study_program_id, 'curriculum_year_id' => $course->curriculum_year_id], ['class' => 'btn btn-primary']) ?> <?= Html::a('<i class="fas fa-plus"></i> Tambah Baru', ['index', 'study_program_id' => $course->study_program_id, 'curriculum_year_id' => $course->curriculum_year_id, 'course_curriculum_id' => $course->id], ['class' => 'btn btn-success']) ?> <?= Html::a('<i class="fas fa-edit"></i> Edit', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?> <?= Html::a('<i class="fas fa-trash"></i> Hapus', ['delete', 'id' => $model->id], ['class' => 'btn btn-danger', 'data' => ['confirm' => 'Hapus prasyarat ini?', 'method' => 'post']]) ?></div></div>
    <div class="card card-success card-outline"><div class="card-body"><div class="row">
        <div class="col-md-6"><table class="table table-sm table-borderless"><tr><th>Tahun Kurikulum</th><td><?= Html::encode($course->curriculumYear->year) ?></td></tr><tr><th>Mata Kuliah</th><td><?= Html::encode($course->subject->code . ' - ' . $course->subject->name . ' - ' . $course->subject->credits . ' SKS') ?></td></tr><tr><th>Prasyarat</th><td><?= Html::encode($prerequisite->subject->code . ' - ' . $prerequisite->subject->name . ' - ' . $prerequisite->subject->credits . ' SKS') ?></td></tr></table></div>
        <div class="col-md-6"><table class="table table-sm table-borderless"><tr><th>Program Studi</th><td><?= Html::encode($course->studyProgram->name) ?></td></tr><tr><th>Jenis Syarat</th><td><?= Html::encode(SubjectPrerequisite::typeOptions()[$model->requirement_type]) ?></td></tr><tr><th>Nilai Min</th><td><?= Html::encode($model->minimum_grade ?: 'Tidak Ada') ?></td></tr></table></div>
    </div></div></div>
</div>
