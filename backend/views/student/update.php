<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Student $model */

$this->title = 'Update Mahasiswa: ' . $model->user->username;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="user-update">

    <?= $this->render('_form', ['model' => $model]) ?>

</div>
