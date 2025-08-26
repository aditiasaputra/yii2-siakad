<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Faculty */

$this->title = 'Edit Fakultas: ' . $model->unit_name;
$this->params['breadcrumbs'][] = ['label' => 'Manajemen Fakultas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->unit_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>

<div class="faculty-update">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= Html::encode($this->title) ?></h1>
        
        <div>
            <?= Html::a('<i class="fas fa-eye"></i> Lihat Detail', ['view', 'id' => $model->id], [
                'class' => 'btn btn-outline-info'
            ]) ?>
            
            <?= Html::a('<i class="fas fa-arrow-left"></i> Kembali ke Daftar', ['index'], [
                'class' => 'btn btn-outline-secondary'
            ]) ?>
        </div>
    </div>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>