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
    'article_upload_files' => [
        'type' => 2,
        'description' => 'Article upload files',
    ],
    'banner_area_view' => [
        'type' => 2,
        'description' => 'Banner area view',
    ],
    'banner_area_create' => [
        'type' => 2,
        'description' => 'Banner area create',
    ],
    'banner_area_update' => [
        'type' => 2,
        'description' => 'Banner area update',
    ],
    'banner_upload_files' => [
        'type' => 2,
        'description' => 'Banner upload files',
    ],
    'banner_view' => [
        'type' => 2,
        'description' => 'Banner view',
    ],
    'banner_create' => [
        'type' => 2,
        'description' => 'Banner create',
    ],
    'banner_update' => [
        'type' => 2,
        'description' => 'Banner update',
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
            'article_upload_files',
            'banner_view',
            'banner_area_view',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'ruleName' => 'userRole',
        'children' => [
            'moderator',
            'banner_create',
            'banner_update',
            'banner_upload_files',
            'banner_area_create',
            'banner_area_update',
        ],
    ],
];
