<?php
//include index.php in order to retrieve config container
require 'public/index.php';

return [
    'paths' => [
        'migrations' => 'db/migrations',
        'seeds' => 'db/seeds'
    ],
    'environments' => [
        'default_database' => 'development',
        'development' => [
            'adapter' => 'mysql',
            'host' => $container->get('database.host'),
            'name' => $container->get('database.name'),
            'user' => $container->get('database.username'),
            'pass' => $container->get('database.password')
        ]
    ]
];
