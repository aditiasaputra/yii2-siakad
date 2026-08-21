<?php

use yii\helpers\Html;

$this->title = 'Tambah Ekivalensi Mata Kuliah';
$this->params['breadcrumbs'][] = ['label' => 'Ekivalensi Mata Kuliah', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-equivalence-create">
    <div class="d-flex justify-content-between align-items-center mb-4"><h1><?= Html::encode($this->title) ?></h1><?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index', 'study_program_id' => $model->study_program_id, 'new_curriculum_year_id' => $model->new_curriculum_year_id, 'old_curriculum_year_id' => $model->old_curriculum_year_id], ['class' => 'btn btn-outline-secondary']) ?></div>
    <?= $this->render('_form', compact('model', 'newSubjects', 'oldSubjects')) ?>
</div>
