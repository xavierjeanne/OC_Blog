<?php

use Framework\Router;
use Framework\Twig\TimeExtension;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;
use Framework\Renderer\TwigRendererFactory;

//config file for the builder container
return [
    //define database host
    'database.host' => 'localhost',
    //define database username
    'database.username' => 'root',
    //define database password
    'database.password' => '',
    //define database name
    'database.name' => 'ocblog',
    //define view path for twig template
    'view_path' => dirname(__DIR__) . DIRECTORY_SEPARATOR . '/views',
    //define twig extension
    'twig.extensions' => [
        \DI\get(TimeExtension::class)
    ],
    //initiate renderer with twig renderer using config.view_path in constructor
    RendererInterface::class => \DI\factory(TwigRendererFactory::class),
    //initiate router
    Router::class => \DI\create(),
    //initaite pdo with config connection
    \PDO::class => function (ContainerInterface $interneContainer) {
        return new PDO(
            'mysql:host=' . $interneContainer->get('database.host') .
                ';dbname=' . $interneContainer->get('database.name'),
            $interneContainer->get('database.username'),
            $interneContainer->get('database.password'),
            [
                //config pdo to retrieve result like object
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                //config pdo to retrieve erreur like exception
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
];
