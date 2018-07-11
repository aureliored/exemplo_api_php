<?php

return [
    'get' => [
        'path' => '',
        'callback' => [
            "Product\\Controller\\ProductController",
            'indexAction',
        ],
        'path' => '/produtos/',
        'callback' => [
            "Product\\Controller\\ProductController",
            'allAction',
        ],
        'path' => '/produto/',
        'callback' => [
            "Product\\Controller\\ProductController",
            'getAction',
        ],
    ],

    'put' => [
        'path' => '/produto/',
        'callback' => [
            "Product\\Controller\\ProductController",
            'editAction',
        ],
    ],

    'delete' => [
        'path' => '/produto/',
        'callback' => [
            "Product\\Controller\\ProductController",
            'removeAction',
        ],
    ],

    'post' => [
        'path' => '/produtos/',
        'callback' => [
            "Product\\Controller\\ProductController",
            'newAction',
        ],
    ],
    
];