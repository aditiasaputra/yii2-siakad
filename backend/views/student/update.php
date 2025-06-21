<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $userModel */
/** @var common\models\Student $studentModel */

$this->title = 'Update: ' . $userModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Mahasiswa', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $userModel->name, 'url' => ['view', 'id' => $studentModel->id]];
$this->params['breadcrumbs'][] = 'Fom Update';
?>
<div class="user-update">

    <?= $this->render('_form', compact('studentModel', 'userModel')) ?>

</div>
