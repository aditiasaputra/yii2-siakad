<?php

/** @var yii\web\View $this */
/** @var common\models\Bank $model */

$this->title = 'Form Bank';
$this->params['breadcrumbs'][] = ['label' => 'Master Bank', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>
