<?php

use yii\helpers\Html;
?>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover mb-0">
        <thead class="thead-dark"><tr><th><?= Html::encode($title) ?></th><th style="width: 120px">Aksi</th></tr></thead>
        <tbody>
        <?php if (!$models): ?>
            <tr><td colspan="2" class="text-center text-muted">Belum ada slot waktu.</td></tr>
        <?php else: ?>
            <?php foreach ($models as $model): ?>
                <tr>
                    <td><?= Html::a(Html::encode($model->formattedTime), ['view', 'id' => $model->id]) ?></td>
                    <td>
                        <?= Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-warning', 'title' => 'Edit']) ?>
                        <?= Html::a('<i class="fas fa-trash"></i>', ['delete', 'id' => $model->id], ['class' => 'btn btn-sm btn-outline-danger', 'title' => 'Hapus', 'data' => ['confirm' => 'Hapus slot waktu ini?', 'method' => 'post']]) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>
