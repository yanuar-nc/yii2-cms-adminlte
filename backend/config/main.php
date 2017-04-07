<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$projectName = 'backend' . $params['project']['firstname'] . $params['project']['lastname'];

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'baseUrl' => $params['baseUrl'].'/backend',
            'enableCookieValidation' => true,
            'enableCsrfValidation' => true,
            'cookieValidationKey' => sha1($projectName),
            'csrfParam' => '_csrf-' . $projectName,
        ],
        'user' => [
            'identityClass' => 'backend\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
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
            'appendTimestamp' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
            'defaultRoles' => ['admin','editor','user'], // here define your roles
            //'authFile' => '@console/data/rbac.php' //the default path for rbac.php | OLD CONFIGURATION
            'itemFile' => '@console/data/items.php', //Default path to items.php | NEW CONFIGURATIONS
            'assignmentFile' => '@console/data/assignments.php', //Default path to assignments.php | NEW CONFIGURATIONS
            'ruleFile' => '@console/data/rules.php', //Default path to rules.php | NEW CONFIGURATIONS
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        'https://code.jquery.com/jquery-2.2.3.min.js',
                    ]
                ],
            ],
        ],
        'urlManager' => [
            'baseUrl' => $params['baseUrl'].'/backend',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'dashboard' => 'site/index',
                '<controller:[0-9a-zA-Z\-]+>/<id:\d+>' => '<controller>/view',
                '<controller:[0-9a-zA-Z\-]+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:[0-9a-zA-Z\-]+>/<action:\w+>' => '<controller>/<action>',

            ],
        ],
        'view' => [
            'class' => 'backend\components\View',
        ]
        /*
        */
    ],
    'params' => $params,
];
