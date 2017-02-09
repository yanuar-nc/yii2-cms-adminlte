<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot/assets';
    public $baseUrl = '@web/web';
    public $css = [
        'bootstrap/css/bootstrap.min.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        'css/font-awesome.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        'plugins/iCheck/square/blue.css'
    ];
    public $js = [
        // 'plugins/jQuery/jquery-2.2.3.min.js',
        // 'plugins/jQueryUI/jquery-ui.min.js',
        'bootstrap/js/bootstrap.min.js',
        'plugins/iCheck/icheck.min.js',
        'js/app.min.js',
        'js/demo.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
