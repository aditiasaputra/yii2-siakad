<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $model */

$this->title = 'Update: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Pengguna', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Form Update';
?>
<div class="user-update">

    <?= $this->render('_form', ['model' => $model]) ?>

</div>
