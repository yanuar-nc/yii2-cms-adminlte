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
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        'plugins/morris/morris.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        // 'plugins/iCheck/square/blue.css',
        'css/ajax-loader.min.css',
        'css/custom.css',
    ];
    public $js = [
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
        'https://code.jquery.com/ui/1.11.4/jquery-ui.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/jQuery-Knob/1.2.13/jquery.knob.min.js',
        // 'js/datatable.js',
        // 'http://webadmin.spbecomm3.com/themes/galeripos/plugins/data-tables/DT_bootstrap.js',
        'https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js',
        'js/pages/dashboard.js',
        // 'js/demo.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
