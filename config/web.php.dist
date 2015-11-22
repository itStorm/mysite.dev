<?php
use kartik\datecontrol\Module as KartikModule;

$config = require(__DIR__ . DIRECTORY_SEPARATOR . 'main.php');

$config['id'] = 'basic';
$config['language'] = 'ru-RU'; // set target language to be Russian
$config['sourceLanguage'] = 'en-US'; // set source language to be English
$config['defaultRoute'] = 'main/default/index';


// COMPONENTS
$config['components']['request'] = [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => 'bgMVkXCa23wI6dLryBtHClAHA2KPXjnQ',
];
$config['components']['user'] = [
    'identityClass'   => 'app\modules\user\models\User',
    'enableAutoLogin' => true,
    'loginUrl'        => '/login'
];
$config['components']['errorHandler'] = [
    'errorAction' => 'main/default/error',
];
$config['components']['mailer'] = [
    'class'            => 'yii\swiftmailer\Mailer',
    // send all mails to a file by default. You have to set
    // 'useFileTransport' to false and configure a transport
    // for the mailer to send real emails.
    'useFileTransport' => true,
];
$config['components']['i18n'] = [
    'translations' => [
        'app*' => [
            'class'          => 'yii\i18n\PhpMessageSource',
            'basePath'       => '@app/messages',
            'sourceLanguage' => 'en-US',
            'fileMap'        => [
                'app' => 'app.php',
            ],
        ],
    ],
];
$config['components']['formatter'] = [
    'class'          => 'yii\i18n\Formatter',
    'dateFormat'     => 'php:j F, Y',
    'datetimeFormat' => 'php:j F, Y H:i:s',
    'timeFormat'     => 'php:H:i:s',
    'timeZone'       => 'Europe/Moscow'
];
$config['components']['log']['traceLevel'] = YII_DEBUG ? 3 : 0;

// MODULES
$config['modules'] = [
    'main'        => [
        'class' => 'app\modules\main\Module',
    ],
    'user'        => [
        'class' => 'app\modules\user\Module',
    ],
    'article'     => [
        'class' => 'app\modules\article\Module',
    ],
    'test'        => [
        'class' => 'app\modules\test\Module',
    ],
    'datecontrol' => [
        'class'           => 'kartik\datecontrol\Module',
        'saveSettings'    => [
            KartikModule::FORMAT_DATE     => 'php:U', // saves as unix timestamp
            KartikModule::FORMAT_TIME     => 'php:H:i:s',
            KartikModule::FORMAT_DATETIME => 'php:U',
        ],
        'displayTimezone' => 'Europe/Moscow',
    ]
];

// DEV CONFIGURATION
if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug']['class'] = 'yii\debug\Module';
    $config['modules']['debug']['allowedIPs'] = ['127.0.0.1', '192.168.*.*'];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii']['class'] = 'yii\gii\Module';
    $config['modules']['gii']['allowedIPs'] = ['127.0.0.1', '192.168.*.*'];
}

return $config;
