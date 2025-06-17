<?php

namespace app\assets;

use yii\web\AssetBundle;

class ToastrAsset extends AssetBundle
{
    public $baseUrl = '@web/plugins/toastr';
    public $css = [
        'toastr.min.css',
    ];
    public $js = [
        'toastr.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
