<?php
$params = array_merge(
    require(__DIR__ . '/params-local.php')
);
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Asia/Jakarta', 
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
       'formatter' => [
           'dateFormat' => 'd-M-Y',
           'datetimeFormat' => 'd-M-Y H:i:s',
           'timeFormat' => 'H:i:s',

           'locale' => 'de-DE', //your language locale
           'defaultTimeZone' => 'Asia/Jakarta', // time zone
        ],
        'view' => [
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'Html' => [ 'class' => '\yii\helpers\Html'],
                        'Url' => [ 'class' => '\yii\helpers\Url' ],
                        'LinkPager' => [ 'class' => '\yii\widgets\LinkPager' ],
                        // 'StringHelper' => '\yii\helpers\StringHelper',
                        'Yii' => [ 'class' => '\Yii' ],
                        'baseUrl' => $params['baseUrl'],
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
                // ...
            ],
        ],
    ],
];
