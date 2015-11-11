<?php
$config = require __DIR__ . '/container/services.php';
return [
    'class' => 'yii\db\Connection',
    'dsn' => $config['parameters']['database']['dsn'],
    'username' => $config['parameters']['database']['username'],
    'password' => $config['parameters']['database']['password'],
    'charset' => 'utf8',
];
