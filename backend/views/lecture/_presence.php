<?php
$this->title = 'Kehadiran';

$this->params['breadcrumbs'][] = ['label' => 'Master Dosen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->name, 'url' => ['index', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <h5>Presence Page</h5>
</div>