<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'view' => [
            'class' => 'backend\components\View',
            'renderers' => [
                'twig' => [
                    'class' => 'yii\twig\ViewRenderer',
                    'cachePath' => '@runtime/Twig/cache',
                    // Array of twig options:
                    'options' => [
                        'auto_reload' => true,
                    ],
                    'globals' => [
                        'html' => '\yii\helpers\Html',
                        'Url' => '\yii\helpers\Url',
                        'LinkPager' => '\yii\widgets\LinkPager',
                        // 'StringHelper' => '\yii\helpers\StringHelper',
                        'Yii' => '\Yii',
                    ],
                    'uses' => ['yii\bootstrap'],
                ],
                // ...
            ],
        ],
    ],
];
