<?php

namespace App\Blog;

use Framework\Router;
use Psr\Container\ContainerInterface;
use App\Blog\Controller\BlogController;
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
        //homepage route
        $router->get('/home', HomepageController::class, 'blog.index');
        //route blog
        $router->get('/blog', BlogController::class, 'blog.blog');
        //route post show
        $router->get('/blog/{id:[0-9]+}', PostShowController::class, 'blog.show');
    }
}
