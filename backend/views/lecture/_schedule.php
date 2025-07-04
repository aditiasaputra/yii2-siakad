<?php
$this->title = 'Jadwal';

$this->params['breadcrumbs'][] = ['label' => 'Master Dosen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->name, 'url' => ['show', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="card">
    <h5>Schedule Page</h5>
</div>