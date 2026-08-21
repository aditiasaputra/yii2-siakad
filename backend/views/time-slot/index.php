<?php

use common\widgets\Alert;
use yii\helpers\Html;

$this->title = 'Slot Waktu';
$this->params['breadcrumbs'][] = $this->title;
?>
<?= Alert::widget() ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0"><?= Html::encode($this->title) ?></h1>
        <?= Html::a('<i class="fas fa-plus mr-1"></i> Tambah Slot Waktu', ['create'], ['class' => 'btn btn-success']) ?>
    </div>
    <div class="card card-success card-outline"><div class="card-body"><div class="row">
        <div class="col-lg-4 col-md-12 mb-3"><?= $this->render('_period_table', ['title' => 'Waktu Pagi (00:00–11:59)', 'models' => $groups['morning']]) ?></div>
        <div class="col-lg-4 col-md-12 mb-3"><?= $this->render('_period_table', ['title' => 'Waktu Siang (12:00–17:59)', 'models' => $groups['afternoon']]) ?></div>
        <div class="col-lg-4 col-md-12 mb-3"><?= $this->render('_period_table', ['title' => 'Waktu Malam (18:00–23:59)', 'models' => $groups['evening']]) ?></div>
    </div></div></div>
</div>
