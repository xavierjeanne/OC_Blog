<?php

namespace App\Admin;

use Framework\Router;
use Psr\Container\ContainerInterface;
use App\Admin\Controller\HomepageAdminController;
use Framework\Renderer\RendererInterface;

/**
 * Module admin class,configurate and initiate the blogmodule with  and route
 */
class AdminModule
{
    /**
     * construct route for this module
     *
     * @param ContainerInterface
     */
    public function __construct(ContainerInterface $container)
    {
        //add views to renderer(instance of renderer by container)
        $container->get(RendererInterface::class)->addPath('admin', __DIR__ . '/views');
        //inject router
        $router = $container->get(Router::class);
        //declare route
        $router->get('/admin', HomepageAdminController::class, 'admin.index');
    }
}