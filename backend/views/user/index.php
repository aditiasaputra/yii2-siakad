<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/** @var $searchModel backend\models\UserSearch */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->registerCss(<<<CSS
#grid-loader {
    display: none;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1001;
}
#user-grid-container {
    position: relative;
}

#user-grid-container.loading::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.2); /* semi-transparan gelap */
    z-index: 1000;
}

#user-grid-container.loading .grid-view {
    opacity: 0.5;
    pointer-events: none;
    user-select: none;
}
CSS);
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
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div id="user-grid-container">
                <div id="grid-loader">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                    </div>
                    <span>Loading...</span>
                </div>
                <?php Pjax::begin(['id' => 'user-grid', 'timeout' => 5000, 'enablePushState' => false]); ?>
                <?= GridView::widget([
                    'id' => 'kv-grid-demo',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $gridColumns,
                    'headerContainer' => ['class' => 'kv-table-header'],
                    'floatHeader' => true,
                    'floatPageSummary' => true,
                    'pjax' => false,
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
                        'heading' => '<i class="fas fa-users"></i>  Data Pengguna',
                        'type' => GridView::TYPE_DARK,
                    ],
                    'exportConfig' => [
                        'html' => [],
                        'csv' => [],
                        'txt' => [],
                        'xls' => [],
                        'pdf' => [],
                        'json' => [],
                    ],
                    // set your toolbar
                    'toolbar' =>  [
                        [
                            'content' =>
                                Html::a('<i class="fas fa-user-plus mr-1"></i>', ['create'], ['class' => 'btn btn-md btn-success', 'title' => "Create User"]) . ' '.
                                Html::a('<i class="fas fa-redo"></i>', ['grid-demo'], [
                                    'class' => 'btn btn-outline-secondary',
                                    'title'=> 'Reset Grid',
                                    'data-pjax' => 0,
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
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>

<?php
$this->registerJs(<<<JS
    $(document).on('pjax:start', function() {
        $('#user-grid-container').addClass('loading');
        $('#grid-loader').fadeIn();
    });
    $(document).on('pjax:end', function() {
        $('#user-grid-container').removeClass('loading');
        $('#grid-loader').fadeOut();
    });
JS);
?>