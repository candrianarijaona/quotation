<?php
return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => true,
        'displayErrorDetails' => true,

        // View settings
        'view' => [
            'template_path' => __DIR__ . '/Quotation/View',
            'twig' => [
                'cache' => __DIR__ . '/../var/cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],
        'db' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'devis',
            'username' => 'root',
            'password' => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/../var/log/app.log',
        ],
    ],
];
