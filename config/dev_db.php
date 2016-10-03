<?php

return [
    'class' => 'yii\db\Connection',
    'dsn' => getenv('APP_DSN'),
    'username' => getenv('APP_USERNAME'),
    'password' => getenv('APP_PASSWORD'),
    'charset' => 'utf8',
];
