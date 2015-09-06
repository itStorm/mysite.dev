<?php
Yii::setAlias('@tests', dirname(__DIR__) . '/tests');
$config = require(__DIR__ . '/main.php');

$config['id'] = 'basic-console';
$config['controllerNamespace'] = 'app\commands';
$config['bootstrap'][] = 'gii';

// MODULES
$config['modules']['gii'] = 'yii\gii\Module';

return $config;
