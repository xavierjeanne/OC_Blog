<?php

namespace App\Blog;

use Framework\Router;
use Psr\Container\ContainerInterface;
use App\Blog\Controllers\BlogController;
use Framework\Renderer\RendererInterface;

/**
 * Module blog class,configurate and initiate the blogmodule with  and route
 */
class BlogModule
{

    /**
     * construct route for this module
     *
     * @param ContainerInterface
     */
    public function __construct(ContainerInterface $container)
    {

        //add views to renderer(instance of renderer by container)
        $container->get(RendererInterface::class)->addPath('blog', __DIR__ . '/Views');
        //inject router
        $router = $container->get(Router::class);
        //declare route 
        $router->get('/blog', BlogController::class, 'blog.index');
    }
}
