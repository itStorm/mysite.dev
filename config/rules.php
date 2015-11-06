<?php
return [
    ''                                                => 'main/default/index',
    '<_a:(contact|about)>'                            => 'main/default/<_a>',
    '<_a:error>'                                      => 'main/default/<_a>',
    '<_a:(login|logout)>'                             => 'user/default/<_a>',
    '<_a:test/.*>'                                    => 'test/default/index',

    'article/<slug:[\w\-]+>'                          => 'article/default/view',
    'article/category/<slug:[\w\-]+>'                 => 'article/default/category',
    'article/<_a:[\w\-]+>/<id:\d+>'                   => 'article/default/<_a>',

    '<_m:[\w\-]+>/<_c:[\w\-]+>/<id:\d+>'              => '<_m>/<_c>/view',
    '<_m:[\w\-]+>/<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_m>/<_c>/<_a>',
    '<_m:[\w\-]+>'                                    => '<_m>/default/index',
    '<_m:[\w\-]+>/<_c:[\w\-]+>'                       => '<_m>/<_c>/index',
];