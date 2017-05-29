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
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css',
        'https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css',
        // 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css',
        // 'https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css',
        'css/AdminLTE.min.css',
        'css/skins/_all-skins.min.css',
        // 'plugins/iCheck/square/blue.css',
        'css/ajax-loader.min.css',
        'css/custom.css',
    ];
    public $js = [
        'https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js',
        'https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js',
        'https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js',
        // 'plugins/ckeditor/ckeditor.js',
        // 'plugins/ckeditor/build-config.js',
        // 'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        'https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js',
        // 'js/datatable.js',
        // 'http://webadmin.spbecomm3.com/themes/galeripos/plugins/data-tables/DT_bootstrap.js',
        'https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.3.11/js/app.min.js',
        'js/demo.js',
        'js/custom.js',

    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
    ];
}
