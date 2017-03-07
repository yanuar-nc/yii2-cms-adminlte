<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'plugins/datatables/dataTables.bootstrap.css',
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        'bootstrap/css/bootstrap.min.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        'css/font-awesome.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        // 'plugins/iCheck/square/blue.css',
        'css/ajax-loader.min.css',
        'css/custom.min.css',
    ];
    public $js = [
        'bootstrap/js/bootstrap.min.js',
        'plugins/datatables/jquery.dataTables.min.js',
        'plugins/datatables/dataTables.bootstrap.min.js',
        'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        // 'js/datatable.js',
        // 'http://webadmin.spbecomm3.com/themes/galeripos/plugins/data-tables/DT_bootstrap.js',
        'js/app.min.js',
        'js/demo.js',
        'js/custom.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        // 'yii\bootstrap\BootstrapAsset',
    ];
}
