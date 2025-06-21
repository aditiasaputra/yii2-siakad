<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $userModel */
/** @var common\models\Employee $employeeModel */
/** @var common\models\Lecture $lectureModel */

$this->title = 'Update: ' . $userModel->name;
$this->params['breadcrumbs'][] = ['label' => 'Master Dosen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $userModel->name, 'url' => ['show', 'id' => $lectureModel->id]];
$this->params['breadcrumbs'][] = 'Form Update';
?>
<div class="lecture-update">

    <?= $this->render('_form',  compact('userModel', 'employeeModel', 'lectureModel')) ?>

</div>
