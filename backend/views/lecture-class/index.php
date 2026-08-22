<?php
use common\widgets\Alert;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
$this->title = 'Kelas Kuliah';
$this->params['breadcrumbs'][] = $this->title;
$params = ['index', 'academic_period' => $academic_period, 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id, 'lecture_system_id' => $lecture_system_id, 'course_class_id' => $course_class_id];
$search = Html::beginForm($params, 'get', ['class' => 'form-inline', 'data-pjax' => 1])
    . Html::hiddenInput('academic_period', $academic_period) . Html::hiddenInput('study_program_id', $study_program_id) . Html::hiddenInput('curriculum_year_id', $curriculum_year_id)
    . '<div class="input-group">' . Html::textInput('q', $q, ['class' => 'form-control', 'placeholder' => 'Cari Kelas Kuliah']) . '<div class="input-group-append">'
    . Html::submitButton('<i class="fas fa-search"></i>', ['class' => 'btn btn-success']) . Html::a('<i class="fas fa-sync-alt"></i>', $params, ['class' => 'btn btn-primary', 'data-pjax' => 1]) . '</div></div>' . Html::endForm();
$toolbar = Html::a('<i class="fas fa-plus"></i>', ['create', 'academic_period' => $academic_period, 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id], ['class' => 'btn btn-success', 'title' => 'Tambah Kelas Kuliah', 'data-pjax' => 0])
    . Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-danger js-delete-lecture-class', 'title' => 'Hapus Semua', 'data-all' => 1, 'data-url' => Url::to(['delete-all', 'academic_period' => $academic_period, 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id])])
    . Html::a('<i class="fas fa-copy mr-1"></i> Generate Kelas', ['generate', 'academic_period' => $academic_period, 'study_program_id' => $study_program_id, 'curriculum_year_id' => $curriculum_year_id], ['class' => 'btn btn-warning', 'data-pjax' => 0]);
?>
<?= Alert::widget() ?>
<div class="d-flex align-items-baseline mb-3"><h1 class="mb-0 mr-2"><?= Html::encode($this->title) ?></h1><span class="text-muted">Daftar Kelas &amp; Jadwal Perkuliahan</span></div>
<div class="card card-warning card-outline"><div class="card-body">
<?= Html::beginForm(['index'], 'get', ['id' => 'lecture-class-filter']) ?><div class="row">
<div class="col-md-4"><?= Html::label('Periode Akademik', null, ['class' => 'text-warning']) ?><?= Select2::widget(['name' => 'academic_period', 'value' => $academic_period, 'data' => $academicPeriods]) ?></div>
<div class="col-md-4"><?= Html::label('Program Studi', null, ['class' => 'text-warning']) ?><?= Select2::widget(['name' => 'study_program_id', 'value' => $study_program_id, 'data' => $studyPrograms]) ?></div>
<div class="col-md-4"><?= Html::label('Kurikulum', null, ['class' => 'text-warning']) ?><?= Select2::widget(['name' => 'curriculum_year_id', 'value' => $curriculum_year_id, 'data' => $curriculumYears]) ?></div>
<div class="col-md-4 mt-3"><?= Html::label('Kelas / Kelompok', null, ['class' => 'text-warning']) ?><?= Select2::widget(['name' => 'course_class_id', 'value' => $course_class_id, 'data' => $courseClasses, 'options' => ['placeholder' => '- Semua Kelas / Kelompok -'], 'pluginOptions' => ['allowClear' => true]]) ?></div>
<div class="col-md-4 mt-3"><?= Html::label('Sistem Kuliah', null, ['class' => 'text-warning']) ?><?= Select2::widget(['name' => 'lecture_system_id', 'value' => $lecture_system_id, 'data' => $lectureSystems, 'options' => ['placeholder' => '- Semua Sistem Kuliah -'], 'pluginOptions' => ['allowClear' => true]]) ?></div>
</div><?= Html::endForm() ?></div></div>
<?= GridView::widget([
    'id' => 'lecture-class-grid', 'dataProvider' => $dataProvider, 'pjax' => true,
    'pjaxSettings' => ['neverTimeout' => true, 'options' => ['id' => 'lecture-class-pjax']],
    'responsive' => false, 'bordered' => true, 'striped' => true, 'condensed' => true, 'hover' => true,
    'panel' => ['heading' => '<i class="fas fa-chalkboard-teacher"></i> Kelas Kuliah', 'type' => GridView::TYPE_DARK, 'before' => $search],
    'toolbar' => [['content' => $toolbar, 'options' => ['class' => 'btn-group mr-2']]],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        ['label' => 'Kur.', 'value' => static fn($m) => $m->curriculum->curriculumYear->year],
        ['label' => 'Kode', 'value' => static fn($m) => $m->curriculum->subject->code],
        ['label' => 'Mata Kuliah', 'value' => static fn($m) => $m->curriculum->subject->name],
        ['attribute' => 'name'], ['label' => 'Pengajar', 'value' => static fn($m) => $m->lecturerNames],
        ['label' => 'Jadwal Mingguan', 'format' => 'raw', 'value' => static fn($m) => $m->scheduleLabel],
        ['attribute' => 'capacity', 'label' => 'Kap.'], ['label' => 'Pst.', 'value' => static fn($model) => 0],
        ['class' => 'kartik\grid\ActionColumn', 'template' => '{view} {update} {delete}', 'width' => '125px', 'buttons' => [
            'view' => static fn($url) => Html::a('<i class="fas fa-eye"></i>', $url, ['class' => 'btn btn-sm btn-info', 'data-pjax' => 0]),
            'update' => static fn($url) => Html::a('<i class="fas fa-edit"></i>', $url, ['class' => 'btn btn-sm btn-primary', 'data-pjax' => 0]),
            'delete' => static fn($url) => Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-sm btn-danger js-delete-lecture-class', 'data-url' => $url]),
        ]],
    ],
    'summary' => 'Menampilkan <b>{begin}-{end}</b> dari <b>{totalCount}</b> data.',
]) ?>
<?php $this->registerJs(<<<'JS'
$('#lecture-class-filter select').on('change',function(){$('#lecture-class-filter').trigger('submit');});
$(document).on('click','.js-delete-lecture-class',function(){var b=$(this),all=b.data('all')==1;Swal.fire({title:all?'Hapus Semua Kelas Kuliah?':'Hapus Kelas Kuliah?',text:'Data yang dihapus tidak dapat dikembalikan.',icon:'warning',showCancelButton:true,confirmButtonColor:'#dc3545',confirmButtonText:'Ya, Hapus',cancelButtonText:'Batal',reverseButtons:true}).then(function(r){if(!r.isConfirmed)return;$.ajax({url:b.data('url'),type:'POST',dataType:'json',data:{_csrf:yii.getCsrfToken()}}).done(function(x){if(x.success){Swal.fire({title:'Berhasil',text:x.message,icon:'success',timer:1400,showConfirmButton:false});$.pjax.reload({container:'#lecture-class-pjax',timeout:0});}else Swal.fire('Gagal',x.message||'Data gagal dihapus.','error');}).fail(function(){Swal.fire('Gagal','Terjadi kesalahan saat menghapus data.','error');});});});
JS); ?>
