<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\Lecture $model */

$this->title = 'Create Lecture';
$this->params['breadcrumbs'][] = ['label' => 'Lectures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <?= $this->render('_form', ['model' => $formModel]) ?>
    </div>
</div>
