<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$projectName = 'frontend' . $params['project']['firstname'] . $params['project']['lastname'];

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => sha1($projectName),
            'csrfParam' => '_csrf-' . $projectName,
            'baseUrl'=>$params['baseUrl'],
        ],
        'user' => [
            'identityClass' => 'common\models\Participant',
            'enableAutoLogin' => true,
            'loginUrl' => ['participant/login'],  
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => $projectName,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'js/jquery-2.2.3.min.js',
                    ]
                ],
                'foundationize\foundation\FoundationAsset' => [
                    'js' => [
                        'js/foundation.min.js',
                        'js/app.js'
                    ]
                ]
            ],
        ],
        'urlManager' => [
            'baseUrl' => $params['baseUrl'].'/',
            'enablePrettyUrl' => true,
            'scriptUrl'=>'/index.php',
            'showScriptName' => false,
            'rules' => require( __DIR__ . '/routes.php' ),
        ],
        'view' => [
            'class' => 'frontend\components\View',
        ]
    ],
    'params' => $params,
];
