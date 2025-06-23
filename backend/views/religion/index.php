<?php

use common\widgets\Alert;
use yii\grid\GridView;
use yii\helpers\Html;

/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Agama';
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Alert::widget() ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" id="religion-container-data">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                // 'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id',
                    'name',
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{update} {delete}',
                        'buttons' => [
                            'update' => function ($url, $model) {
                                return Html::a('<i class="fas fa-edit"></i>', ['update', 'id' => $model->id], [
                                    'title' => 'Update',
                                    'class' => 'btn btn-xs btn-warning me-1',
                                    'onclick' => 'return event.stopPropagation();'
                                ]);
                            },
                            'delete' => function ($url, $model) {
                                return Html::a('<i class="fas fa-trash"></i>', $url, [
                                    'title' => 'Delete',
                                    'class' => 'btn btn-xs btn-danger',
                                    'data-confirm' => 'Are you sure you want to delete this item?',
                                    'data-method' => 'post',
                                ]);
                            },
                        ],
                        'contentOptions' => ['class' => 'text-nowrap'],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>