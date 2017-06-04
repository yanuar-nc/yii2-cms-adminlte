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
        'ActiveForm' => [ 'class' => '\yii\widgets\ActiveForm'],
       'formatter' => [
           'dateFormat' => 'd-M-Y',
           'datetimeFormat' => 'd-M-Y H:i:s',
           'timeFormat' => 'H:i:s',

           'locale' => 'de-DE', //your language locale
           'defaultTimeZone' => 'Asia/Jakarta', // time zone
        ],
    ],
];
