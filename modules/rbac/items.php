<?php
return [
    'article_view' => [
        'type' => 2,
        'description' => 'Article view',
    ],
    'article_create' => [
        'type' => 2,
        'description' => 'Article create',
    ],
    'article_update' => [
        'type' => 2,
        'description' => 'Article update',
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
        'ruleName' => 'userRole',
        'children' => [
            'article_view',
        ],
    ],
    'moderator' => [
        'type' => 1,
        'description' => 'Moderator',
        'ruleName' => 'userRole',
        'children' => [
            'user',
            'article_create',
            'article_update',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'ruleName' => 'userRole',
        'children' => [
            'moderator',
        ],
    ],
];
