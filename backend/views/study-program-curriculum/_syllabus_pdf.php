<?php
use yii\helpers\Html;
?>
<div class="report-title"><h2>SILABUS KURIKULUM PROGRAM STUDI</h2><h3><?= Html::encode($studyProgram->name) ?></h3></div>
<?php
$entriesBySemester = [];
foreach ($entries as $entry) {
    $entriesBySemester[(int) $entry->semester][] = $entry;
}
$renderTable = static function ($periodLabel, $semester, $rows) {
    ob_start(); ?>
    <table class="table table-bordered semester-table" style="width:100%">
        <thead>
            <?php if ($periodLabel): ?><tr><th colspan="5" class="period-heading"><?= Html::encode($periodLabel) ?></th></tr><?php endif; ?>
            <tr><th colspan="5" class="semester-heading">SEMESTER <?= (int) $semester ?></th></tr>
            <tr><th>No</th><th>Kode</th><th>Mata Kuliah</th><th>SKS</th><th>Status</th></tr>
        </thead>
        <tbody>
        <?php if (!$rows): ?><tr><td colspan="5" style="text-align:center">Belum ada data.</td></tr><?php endif; ?>
        <?php foreach ($rows as $index => $entry): ?><tr><td><?= $index + 1 ?></td><td><?= Html::encode($entry->subject->code) ?></td><td><?= Html::encode($entry->subject->name) ?></td><td><?= (int) $entry->subject->credits ?></td><td><?= $entry->is_mandatory ? 'Wajib' : 'Pilihan' ?></td></tr><?php endforeach; ?>
        </tbody>
    </table>
    <div class="semester-gap">&nbsp;</div>
    <?php return ob_get_clean();
};
$renderSemesterColumn = static function ($periodLabel, array $semesters) use ($entriesBySemester, $renderTable) {
    $html = '';
    foreach ($semesters as $index => $semester) {
        $html .= $renderTable($index === 0 ? $periodLabel : null, $semester, $entriesBySemester[$semester] ?? []);
    }
    return $html;
};
?>
<table class="semester-layout" style="width:100%;border-collapse:collapse"><tr>
    <td style="width:49%;vertical-align:top;padding-right:8px"><?= $renderSemesterColumn('SEMESTER GANJIL', [1, 3, 5, 7]) ?></td>
    <td style="width:49%;vertical-align:top;padding-left:8px"><?= $renderSemesterColumn('SEMESTER GENAP', [2, 4, 6, 8]) ?></td>
</tr></table>
