<?php
$config = require(__DIR__ . DIRECTORY_SEPARATOR . 'main.php');
Yii::setAlias('@tests', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'tests');
Yii::setAlias('@webroot', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'web');

$config['id'] = 'basic-console';
$config['controllerNamespace'] = 'app\commands';
$config['bootstrap'][] = 'gii';

// MODULES
$config['modules']['gii'] = 'yii\gii\Module';
$config['components']['urlManager']['baseUrl'] = '';
$config['components']['urlManager']['hostInfo'] = 'http://racocat.com';

return $config;
