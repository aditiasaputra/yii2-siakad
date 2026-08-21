<?php

use kartik\grid\GridView;
use yii\helpers\Html;

$this->title = 'Mata Kuliah';
$this->params['breadcrumbs'][] = $this->title;
$searchName = $searchModel->formName();
?>
<div class="row">
    <div class="col-lg-3 col-md-4">
        <div class="card card-warning card-outline">
            <div class="card-header"><h3 class="card-title"><i class="fas fa-filter mr-2"></i>FILTER</h3></div>
            <div class="card-body p-0">
                <?php foreach ([
                    ['Tahun Kurikulum', 'curriculum_year_id', $curriculumYears],
                    ['Unit / Prodi Pengampu', 'study_program_id', $studyPrograms],
                    ['Jenis Mata Kuliah', 'subject_type_id', $subjectTypes],
                    ['Kelompok Mata Kuliah', 'subject_group_id', $subjectGroups],
                ] as [$label, $attribute, $items]): ?>
                    <div class="border-bottom p-3"><strong><?= Html::encode($label) ?></strong><div class="mt-2" style="max-height:180px;overflow:auto">
                        <?= Html::a('Semua', ['index'], ['class' => empty($searchModel->$attribute) ? 'font-weight-bold' : '']) ?><br>
                        <?php foreach ($items as $id => $name): ?><?= Html::a(Html::encode($name), ['index', $searchName => [$attribute => $id]], ['class' => (string)$searchModel->$attribute === (string)$id ? 'font-weight-bold text-success' : 'text-success']) ?><br><?php endforeach; ?>
                    </div></div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-9 col-md-8">
        <?= GridView::widget([
            'id' => 'subject-grid', 'dataProvider' => $dataProvider, 'filterModel' => $searchModel,
            'pjax' => false, 'responsive' => true, 'bordered' => true, 'striped' => true, 'condensed' => true, 'hover' => true,
            'panel' => ['heading' => '<i class="fas fa-book"></i> Daftar Mata Kuliah', 'type' => GridView::TYPE_DARK],
            'toolbar' => [[ 'content' => Html::a('<i class="fas fa-plus"></i> Tambah', ['create'], ['class' => 'btn btn-success']) . ' ' . Html::a('<i class="fas fa-copy"></i> Salin Mata Kuliah', ['copy'], ['class' => 'btn btn-warning']) . ' ' . Html::a('<i class="fas fa-redo"></i>', ['index'], ['class' => 'btn btn-primary', 'title' => 'Reset'])], '{export}', '{toggleData}'],
            'columns' => [
                ['class' => 'kartik\grid\CheckboxColumn'],
                ['attribute' => 'curriculum_year_id', 'label' => 'Kurikulum', 'filter' => $curriculumYears, 'value' => static fn($m) => $m->curriculumYear->year],
                ['attribute' => 'code', 'width' => '130px'],
                ['attribute' => 'name', 'value' => static fn($m) => $m->name],
                ['attribute' => 'credits', 'label' => 'SKS', 'width' => '70px', 'hAlign' => GridView::ALIGN_CENTER],
                ['attribute' => 'study_program_id', 'label' => 'Prodi Pengampu', 'filter' => $studyPrograms, 'value' => static fn($m) => $m->studyProgram->name],
                ['class' => 'kartik\grid\ActionColumn', 'width' => '125px', 'template' => '{view} {update} {delete}', 'buttons' => [
                    'view' => static fn($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-info']),
                    'update' => static fn($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-warning']),
                    'delete' => static fn($url) => Html::a('<i class="fas fa-trash"></i>', $url, ['class' => 'btn btn-sm btn-danger', 'data' => ['confirm' => 'Hapus mata kuliah ini?', 'method' => 'post']]),
                ]],
            ],
            'export' => ['showConfirmAlert' => false],
        ]) ?>
    </div>
</div>
