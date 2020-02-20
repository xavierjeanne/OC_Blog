<?php

namespace App\Blog;

use Framework\Router;
use Psr\Container\ContainerInterface;
use Framework\Renderer\RendererInterface;
use App\Blog\Controller\HomepageController;
use App\Blog\Controller\PostShowController;

class BlogModule
{
    public function __construct(ContainerInterface $container)
    {
        //add views to renderer(instance of renderer by container)
        $container->get(RendererInterface::class)->addPath('blog', __DIR__ . '/views');
        //inject router
        $router = $container->get(Router::class);
        //declare route
        //route homepage
        $router->get('/blog', HomepageController::class, 'blog.index');
        //route post show
        $router->get('/blog/{id:[0-9]+}', PostShowController::class, 'blog.show');
    }
}
