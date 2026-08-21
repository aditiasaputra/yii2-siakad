<?php

use yii\helpers\Html;
?>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover mb-0">
        <thead class="thead-dark"><tr><th colspan="5" class="text-center">Semester <?= $semester ?></th></tr><tr><th>No</th><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th style="width:130px">Aksi</th></tr></thead>
        <tbody>
        <?php if (!$entries): ?><tr><td colspan="5" class="text-center text-muted">Belum ada mata kuliah.</td></tr><?php endif; ?>
        <?php foreach ($entries as $index => $entry): ?><tr>
            <td><?= $index + 1 ?></td><td><?= Html::encode($entry->subject->code) ?></td><td><?= Html::a(Html::encode($entry->subject->name), ['view', 'id' => $entry->id]) ?></td><td><?= Html::encode($entry->subject->credits) ?></td>
            <td>
                <?= Html::a('<i class="fas fa-cogs"></i>', ['subject-prerequisite/index', 'study_program_id' => $entry->study_program_id, 'curriculum_year_id' => $entry->curriculum_year_id, 'course_curriculum_id' => $entry->id], ['class' => 'btn btn-sm btn-warning', 'title' => 'Lihat Prasyarat']) ?>
                <?= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $entry->id], ['class' => 'btn btn-sm btn-primary', 'title' => 'Edit']) ?>
                <?= Html::button('<i class="fas fa-trash"></i>', ['class' => 'btn btn-sm btn-danger js-delete-curriculum', 'title' => 'Hapus', 'data-url' => \yii\helpers\Url::to(['delete', 'id' => $entry->id])]) ?>
            </td>
        </tr><?php endforeach; ?>
        </tbody>
    </table>
</div>
