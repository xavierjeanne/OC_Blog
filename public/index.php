<?php


use DI\ContainerBuilder;
use Framework\Renderer\RendererInterface;
use GuzzleHttp\Psr7\ServerRequest;
use Framework\Renderer\TwigRenderer;

//load autoloader
require dirname(__DIR__) . '/vendor/autoload.php';


//array of  module for app
$modules = [
    \App\Blog\BlogModule::class
];

//create container builder
$builder = new ContainerBuilder();

//add global config definition to builder
$builder->addDefinitions(dirname(__DIR__) . '/config/config.php');

//build container
$container = $builder->build();

//create application with load module and container
$app = new \Framework\App($container, $modules);

//get response from request
$response = $app->run(ServerRequest::fromGlobals());

//send response to client
\Http\Response\send($response);
