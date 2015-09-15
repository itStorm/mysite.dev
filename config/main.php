<?php

Yii::setAlias('@common', dirname(__DIR__) . '/common');
Yii::setAlias('@modules', dirname(__DIR__) . '/modules');
Yii::setAlias('@files', dirname(__DIR__) . '/web/files');

return [
    'basePath'   => dirname(__DIR__),
    'bootstrap'           => ['log'],
    'components' => [
        'db'          => require(__DIR__ . '/db.php'),
        'class' => 'yii\caching\FileCache',
        'log'   => [
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
    ],
    'params'     => require(__DIR__ . '/params.php'),
];