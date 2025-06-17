<?php

namespace app\assets;

use yii\web\AssetBundle;

class SweetAlert2Asset extends AssetBundle
{
    public $baseUrl = '@web/plugins/sweetalert2';
    public $css = [
        'sweetalert2.min.css',
    ];
    public $js = [
        'sweetalert2.all.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
