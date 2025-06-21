<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Employee $employeeModel */
/** @var common\models\User $userModel */

$this->title = 'Update: ' . $employeeModel->user->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Mahasiswa', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $employeeModel->user->name, 'url' => ['view', 'id' => $employeeModel->id]];
$this->params['breadcrumbs'][] = 'Form Update';
?>
<div class="employee-update">

    <?= $this->render('_form', compact('employeeModel', 'userModel')); ?>

</div>
