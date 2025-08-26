<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/** @var $searchModel backend\models\UserSearch */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Master Fakultas';
$this->params['breadcrumbs'][] = $this->title;

$gridColumns = [
        [
            'class' => 'kartik\grid\SerialColumn',
            'width' => '30px',
        ],
        [
            'class' => 'kartik\grid\CheckboxColumn',
            'width' => '20px',
        ],
        [
            'attribute' => 'unit_code',
            'width' => '100px',
            'value' => function ($model) {
                return Html::tag('code', $model->unit_code);
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'unit_name',
            'width' => '250px',
            'value' => function ($model) {
                return Html::a($model->unit_name, ['view', 'id' => $model->id], [
                    'class' => 'text-decoration-none'
                ]);
            },
            'format' => 'raw',
        ],
        [
            'attribute' => 'abbreviation',
            'width' => '100px',
        ],
        [
            'attribute' => 'dean',
            'width' => '200px',
        ],
        [
            'attribute' => 'phone',
            'width' => '120px',
        ],
        [
            'attribute' => 'is_active',
            'width' => '100px',
            'value' => function ($model) {
                return Html::a($model->getStatusBadge(), ['toggle-status', 'id' => $model->id], [
                    'class' => 'toggle-status'
                ]);
            },
            'format' => 'raw',
            'filter' => [1 => 'Aktif', 0 => 'Tidak Aktif'],
        ],
        [
            'class' => 'kartik\grid\ActionColumn',
            'width' => '120px',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'view' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-eye"></i>', ['show', 'id' => $model->id], [
                        'title' => 'Lihat',
                        'class' => 'btn btn-sm btn-outline-info',
                    ]);
                },
                'update' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-edit"></i>', $url, [
                        'title' => 'Edit',
                        'class' => 'btn btn-sm btn-outline-warning',
                    ]);
                },
                'delete' => function ($url, $model, $key) {
                    return Html::a('<i class="fas fa-trash"></i>', $url, [
                        'title' => 'Hapus',
                        'class' => 'btn btn-sm btn-outline-danger',
                        'data' => [
                            'confirm' => 'Apakah Anda yakin ingin menghapus fakultas ini?',
                            'method' => 'post',
                        ],
                    ]);
                },
            ],
        ],
    ];

$pdfHeader = [
    'L' => [
        'content' => 'Master Fakultas',
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
                                    <em>* Tabel ini menampilkan daftar fakultas yang terdaftar beserta status dan tanggal pendaftarannya.</em>
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
                    'heading' => '<i class="fas fa-users"></i>  Master Fakultas',
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
                        'filename' => 'Master-Fakultas-' . date('Ymd'),
                    ],
                    GridView::CSV => [
                        'label' => 'CSV',
                        'filename' => 'Master-Fakultas-' . date('Ymd'),
                    ],
                    GridView::PDF => [
                        'label' => 'PDF',
                        'filename' => 'Master-Fakultas-' . date('Ymd'),
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
                    //     'filename' => 'Master-Fakultas-' . date('Ymd'),
                    // ],
                    // GridView::TEXT => [
                    //     'label' => 'Text',
                    //     'filename' => 'Master-Fakultas-' . date('Ymd'),
                    // ],
                    // GridView::JSON => [
                    //     'label' => 'JSON',
                    //     'filename' => 'Data-Fakultas-' . date('Ymd'),
                    // ],
                ],
                // set your toolbar
                'toolbar' =>  [
                    [
                        'content' =>
                            Html::a('<i class="fas fa-plus mr-1"></i>', ['create'], ['class' => 'btn btn-md btn-success', 'title' => "Tambah Fakultas", 'onclick' => 'return event.stopPropagation();']) . ' '.
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