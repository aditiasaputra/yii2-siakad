<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\User $userModel */
/** @var common\models\Student $studentModel */

$this->title = 'Form Mahasiswa';
$this->params['breadcrumbs'][] = ['label' => 'Master Mahasiswa', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <?= $this->render('_form', compact('studentModel', 'userModel')) ?>
    </div>
</div>
