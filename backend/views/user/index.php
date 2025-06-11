<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/** @var $searchModel backend\models\UserSearch */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\\grid\\SerialColumn'],
    'id',
    [
        'attribute' => 'name',
        'label' => 'Nama',
    ],
    [
        'attribute' => 'username',
        'label' => 'Username',
    ],
    [
        'attribute' => 'email',
        'label' => 'Email',
    ],
    [
        'attribute' => 'status',
        'label' => 'Status Akun',
    ],
    [
        'attribute' => 'created_at',
        'label' => 'Tanggal Dibuat',
        'format' => ['datetime'],
    ],
    [
        'class' => 'kartik\\grid\\ActionColumn',
        'template' => '{view} {update} {delete}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<i class="fas fa-eye"></i>', $url, [
                    'title' => 'View',
                    'class' => 'btn btn-xs btn-info me-1',
                ]);
            },
            'update' => function ($url, $model) {
                return Html::a('<i class="fas fa-edit"></i>', $url, [
                    'title' => 'Update',
                    'class' => 'btn btn-xs btn-warning me-1',
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
    [
        'class' => 'kartik\grid\CheckboxColumn',
        'headerOptions' => ['class' => 'kartik-sheet-style'],
        'pageSummaryOptions' => ['colspan' => 3, 'data-colspan-dir' => 'rtl']
    ],
];

$pdfHeader = [
    'L' => [
        'content' => 'Master User',
        'font-size' => 8,
        'color' => '#333333',
    ],
    'C' => [
        'content' => $this->title,
        'font-size' => 16,
        'color' => '#333333',
    ],
    'R' => [
        'content' => 'Generated: '.date('D, d-M-Y'),
        'font-size' => 8,
        'color' => '#333333',
    ],
];
$pdfFooter = [
    'L' => [
        'content' => 'Test',
        'font-size' => 8,
        'font-style' => 'B',
        'color' => '#999999',
    ],
    'R' => [
        'content' => '1',
        'font-size' => 10,
        'font-style' => 'B',
        'font-family' => 'serif',
        'color' => '#333333',
    ],
    'line' => true,
];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" id="user-container-data">
            <?= GridView::widget([
                'id' => 'kv-grid-demo',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'headerContainer' => ['class' => 'kv-table-header'],
                'floatHeader' => true,
                'floatPageSummary' => true,
                'pjax' => true,
                'responsive' => false,
                'bordered' => true,
                'striped' => true,
                'condensed' => true,
                'hover' => true,
                'showPageSummary' => false,
                'panel' => [
                    'after' => '
                            <div class="d-flex justify-content-between align-items-end px-3 py-2">
                                <div>
                                    <em>* Tabel ini menampilkan daftar pengguna yang terdaftar beserta status dan tanggal pendaftarannya.</em>
                                </div>
                                <div>
                                    <button type="button" class="btn btn-primary" onclick="
                                        console.log($(\'#kv-grid-demo\'));
                                        var keys = $(\'#kv-grid-demo\').yiiGridView(\'getSelectedRows\');
                                        if (keys.length > 0) {
                                            alert(\'Downloaded \' + keys.length + \' selected users.\');
                                            // console.log(keys);
                                        } else {
                                            alert(\'No rows selected for download.\');
                                        }
                                    ">
                                        <i class="fas fa-download"></i> Download Selected
                                    </button>
                                </div>
                            </div>
                        ',
                    'heading' => '<i class="fas fa-users"></i>  Master User',
                    'type' => GridView::TYPE_DARK,
                ],
                'export' => [
                    'showConfirmAlert' => false,
                    'target' => GridView::TARGET_BLANK,
                    'showPageSummary' => true,
                ],
                'exportConfig' => [
                    GridView::HTML => [
                        'label' => 'HTML',
                        'filename' => 'Master-User-' . date('Ymd'),
                    ],
                    GridView::CSV => [
                        'label' => 'CSV',
                        'filename' => 'Master-User-' . date('Ymd'),
                    ],
                    GridView::TEXT => [
                        'label' => 'Text',
                        'filename' => 'Master-User-' . date('Ymd'),
                    ],
                    GridView::EXCEL => [
                        'label' => 'Excel',
                        'filename' => 'Master-User-' . date('Ymd'),
                    ],
                    GridView::PDF => [
                        'label' => 'PDF',
                        'filename' => 'Master-User-' . date('Ymd'),
                        'config' => [
                            'methods' => [
                                'SetHeader' => [
                                    ['odd' => $pdfHeader, 'even' => $pdfHeader],
                                ],
                                'SetFooter' => [
                                    ['odd' => $pdfFooter, 'even' => $pdfFooter],
                                ],
                            ],
                        ],
                    ],
                    GridView::JSON => [
                        'label' => 'JSON',
                        'filename' => 'Data-User-' . date('Ymd'),
                    ],
                ],
                // set your toolbar
                'toolbar' =>  [
                    [
                        'content' =>
                            Html::a('<i class="fas fa-user-plus mr-1"></i>', ['create'], ['class' => 'btn btn-md btn-success', 'title' => "Create User", 'onclick' => 'return event.stopPropagation();']) . ' '.
                            Html::a('<i class="fas fa-redo"></i>', ['index'], [
                                'class' => 'btn btn-outline-secondary',
                                'title'=> 'Reset Grid',
                                'data-pjax' => 0,
                                'onclick' => 'return event.stopPropagation();',
                            ]),
                        'options' => ['class' => 'btn-group mr-2 me-2']
                    ],
                    '{export}',
                    '{toggleData}',
                ],
                'toggleDataContainer' => ['class' => 'btn-group mr-2 me-2'],
                'persistResize' => false,
                'toggleDataOptions' => ['minCount' => 10],
                'itemLabelSingle' => 'book',
                'itemLabelPlural' => 'books'
            ]); ?>
        </div>
    </div>
</div>