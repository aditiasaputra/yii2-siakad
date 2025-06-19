<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $userModel */
/** @var common\models\Employee $employeeModel */

$this->title = 'Create Employee';
$this->params['breadcrumbs'][] = ['label' => 'Employees', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <?= $this->render('_form', compact('userModel', 'employeeModel')) ?>
    </div>
</div>
