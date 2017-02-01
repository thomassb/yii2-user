<?php

$params = array_merge(
        require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

$config = [
    'id' => 'app-frontend',
    'name' => 'SPAT',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    //'defaultRoute' => 'extendedController',

    'components' => [
        'db' => require(__DIR__ . '/../../common/config/db.php'),
        'request' => [
            'csrfParam' => '_csrf-spat-f',
        ],
        'user' => [
            'class' => 'common\user\components\User',
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
//        'user' => [
//            'identityClass' => 'common\models\User',
//            'enableAutoLogin' => true,
//            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
//        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => '_identity-spat-f',
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
        
          'urlManager' => [
          'enablePrettyUrl' => true,
          'showScriptName' => false,
          'rules' => [
          ],
          ],
         
        'controller' => [
            'class' => 'common\controllers\extendedController',
        ],
        
        'view' => [
            'class' => 'common\classes\extendedView',
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/main/',
                    '@common/user/views' => '@app/themes/main/user/', // example: @app/views/user/default/login.php
                ],
                'baseUrl' => "/themes/main",
                'basePath' => '@app/themes/main',
            ],
        ],
    ],
    'modules' => [
        'dynagrid' => [
            'class' => '\kartik\dynagrid\Module',
        // other module settings
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        // other module settings
        ],
        'user' => [
            'class' => 'common\user\Module',
        // set custom module properties here ...
        ]
    ],
    'params' => $params,
];
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
};
return $config;
