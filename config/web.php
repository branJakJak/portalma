<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'Portal Money Active',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'view' => [
            'theme' => [
                'pathMap' => [
                    'class' => \yii\base\Theme::className(),
                    '@app/views' => '@app/themes/dashgum'
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'vLpCrGmyUHg$34z+Y=s:',
        ],
        'dataretriever'=>[
            'class'=>'app\components\PbDataRetriever'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\UserAccount',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],        
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'formatter' => [
            'dateFormat' => 'medium',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => array(
                'register' => '/user-accounts/create',
                'login' => '/site/login',
                'logout' => '/site/logout',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
    ],
    'params' => $params,
];

if (YII_DEBUG) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs'=>['*.*.*.*']
    ];
     $config['components']['db'] = require(__DIR__ . '/dev_db.php');
}else {
     $config['components']['db'] = require(__DIR__ . '/db.php');
}

return $config;
