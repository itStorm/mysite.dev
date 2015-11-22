<?php

Yii::setAlias('@common', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'common');
Yii::setAlias('@modules', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'modules');
Yii::setAlias('@files', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'files');

return [
    'basePath'   => dirname(__DIR__),
    'bootstrap'  => ['log'],
    'components' => [
        'db'          => require(__DIR__ . '/db.php'),
        'class'       => 'yii\caching\FileCache',
        'log'         => [
            'targets' => [
                [
                    'class'  => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'authManager' => [
            'class'          => 'yii\rbac\PhpManager',
            'defaultRoles'   => ['user', 'moderator', 'admin'], //здесь прописываем роли
            //зададим куда будут сохраняться наши файлы конфигураций RBAC
            'itemFile'       => '@modules/rbac/items.php',
            'assignmentFile' => '@modules/rbac/assignments.php',
            'ruleFile'       => '@modules/rbac/rules.php'
        ],
        'urlManager'  => [
            'class'           => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => require(__DIR__ . '/rules.php'),
        ]
    ],
    'params'     => require(__DIR__ . '/params.php'),
];