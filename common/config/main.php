<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
         'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
		 'db' => require(__DIR__ . '/db.php'),
    ],
];
