<?php

namespace App\Blog;

use Framework\Router;
use Psr\Container\ContainerInterface;
use App\Blog\Controller\HomepageController;
use Framework\Renderer\RendererInterface;

class BlogModule
{
    public function __construct(ContainerInterface $container)
    {
        //add views to renderer(instance of renderer by container)
        $container->get(RendererInterface::class)->addPath('blog', __DIR__ . '/views');
        //inject router
        $router = $container->get(Router::class);
        //declare route
        $router->get('/blog', HomepageController::class, 'blog.index');
    }
}
