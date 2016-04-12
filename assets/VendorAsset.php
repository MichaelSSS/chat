<?php

namespace app\assets;

use yii\web\AssetBundle;

class VendorAsset extends AssetBundle
{
    public $sourcePath = '@app/assets/vendor';
    public $css = [
    ];
    public $js = [
        'angular/js/angular.min.js',
        'angular/js/angular-route.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
