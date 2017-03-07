<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'bootstrap/css/bootstrap.min.css',
        'plugins/morris/morris.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        'css/font-awesome.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        // 'plugins/iCheck/square/blue.css',
        'css/ajax-loader.css',
        'css/custom.css',
    ];
    public $js = [
        'bootstrap/js/bootstrap.min.js',
        'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        'plugins/morris/raphel.min.js',
        'plugins/morris/morris.min.js',
        'plugins/knob/jquery.knob.js',
        'js/pages/dashboard.js',
        // 'js/datatable.js',
        // 'http://webadmin.spbecomm3.com/themes/galeripos/plugins/data-tables/DT_bootstrap.js',
        'js/app.min.js',
        // 'js/demo.js',
        'css/ajax-loader.min.css',
        'css/custom.min.css',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
