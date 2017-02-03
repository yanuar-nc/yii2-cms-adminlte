<?php
$config = [
    'modules' => [
        'gii' => [
          'class' => 'yii\gii\Module', //adding gii module
          'allowedIPs' => ['127.0.0.1', '::1']  //allowing ip's 
        ],
    ],
];
return $config;