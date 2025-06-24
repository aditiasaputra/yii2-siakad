<?php


/** @var yii\web\View $this */
/** @var common\models\Religion $model */

$this->title = 'Form Agama';
$this->params['breadcrumbs'][] = ['label' => 'Master Agama', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12 col-md-12">
        <?= $this->render('_form', ['model' => $model]) ?>
    </div>
</div>
