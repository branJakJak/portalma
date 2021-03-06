<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'MT',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'agentEntriesReport'=>[
            'class'=>'app\components\AgentEntriesReport'
        ],
        'poxVsLeadRetriever'=>[
            'class'=>'app\components\PoxLeadRetriever'
        ],
        'totalRevenueTodayRetriever'=>[
            'class'=>'app\components\TotalRevenueTodayRetriever'
        ],
        'weeklyRevenueRetriever'=>[
            'class'=>'app\components\WeeklyRevenueRetriever',
            'dayRevenueRetriever'=>'app\components\DayRevenueRetriever'
        ],
        'monthlyRevenueRetriever'=>[
            'class'=>'app\components\MonthlyRevenueRetriever'
        ],

        'view' => [
            'theme' => [
                'pathMap' => [
                    'class' => \yii\base\Theme::className(),
                    '@app/views' => '@app/themes/dashgum'
                ],
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
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
                '/leads' => '/money-active-claims/index',
                '/leads/<action:\w+>' => '/money-active-claims/<action>',
                '/leads/<action:\w+>/<id:\d+>' => '/money-active-claims/<action>',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'db'=>require(__DIR__ . '/db.php'),
    ],
    'modules'=>[
        'api'=>[
            'class'=>'app\modules\Api\ApiModule'
        ]
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
}
return $config;
