<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/** @var $searchModel backend\models\UserSearch */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Karyawan';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
    ['class' => 'yii\\grid\\SerialColumn'],
    'id',
    [
        'attribute' => 'employee_number',
        'label' => 'NIP',
    ],
    [
        'attribute' => 'name',
        'label' => 'Nama',
        'format' => 'raw',
        'value' => function ($model) {
            return $model->user->name;
        },
    ],
    [
        'attribute' => 'email',
        'label' => 'Email',
        'value' => function ($model) {
            return $model->user->email;
        }
    ],
    [
        'attribute' => 'gender',
        'label' => 'Jenis Kelamin',
        'format' => 'raw',
        'value' => function ($model) {
            return $model->user->getGenderLabel();
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => [
            0 => 'Perempuan',
            1 => 'Laki-laki',
        ],
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih Jenis Kelamin'],
    ],
    [
        'attribute' => 'status',
        'label' => 'Status Akun',
        'format' => 'raw',
        'value' => function ($model) {
            return $model->user->getStatusLabel();
        },
        'filterType' => GridView::FILTER_SELECT2,
        'filter' => [
            10 => 'Active',
            9 => 'Inactive',
            0 => 'Deleted',
        ],
        'filterWidgetOptions' => [
            'pluginOptions' => ['allowClear' => true],
        ],
        'filterInputOptions' => ['placeholder' => 'Pilih Status'],
    ],
    [
        'attribute' => 'created_at',
        'label' => 'Tanggal Dibuat',
        'format' => 'raw',
        'value' => function ($model) {
            return Yii::$app->formatter->asDatetime($model->created_at);
        },
        'filterType' => GridView::FILTER_DATE_RANGE,
        'filterWidgetOptions' => [
            'convertFormat' => true,
            'pluginOptions' => [
                'locale' => ['format' => 'Y-m-d'],
                'autoUpdateInput' => false,
            ],
        ],
    ],
    [
        'class' => 'kartik\\grid\\ActionColumn',
        'template' => '{view} {update} {delete}',
        'buttons' => [
            'view' => function ($url, $model) {
                return Html::a('<i class="fas fa-eye"></i>', ['show', 'id' => $model->id], [
                    'title' => 'View',
                    'class' => 'btn btn-xs btn-info me-1',
                    'onclick' => 'return event.stopPropagation();'
                ]);
            },
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
    // [
    //     'class' => 'kartik\grid\CheckboxColumn',
    //     'headerOptions' => ['class' => 'kartik-sheet-style'],
    //     'pageSummaryOptions' => ['colspan' => 3, 'data-colspan-dir' => 'rtl']
    // ],
];

$pdfHeader = [
    'L' => [
        'content' => 'Master Karyawan',
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
                            <!-- <div class="d-flex justify-content-between align-items-end px-3 py-2">
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
                            </div> -->
                        ',
                    'heading' => '<i class="fas fa-users"></i>  Master Karyawan',
                    'type' => GridView::TYPE_DARK,
                ],
                'export' => [
                    'showConfirmAlert' => false,
                    'target' => GridView::TARGET_BLANK,
                    'showPageSummary' => true,
                ],
                'exportConfig' => [
                    GridView::EXCEL => [
                        'label' => 'Excel',
                        'filename' => 'Master-User-' . date('Ymd'),
                    ],
                    GridView::CSV => [
                        'label' => 'CSV',
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
                    // GridView::HTML => [
                    //     'label' => 'HTML',
                    //     'filename' => 'Master-User-' . date('Ymd'),
                    // ],
                    // GridView::TEXT => [
                    //     'label' => 'Text',
                    //     'filename' => 'Master-User-' . date('Ymd'),
                    // ],
                    // GridView::JSON => [
                    //     'label' => 'JSON',
                    //     'filename' => 'Data-User-' . date('Ymd'),
                    // ],
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