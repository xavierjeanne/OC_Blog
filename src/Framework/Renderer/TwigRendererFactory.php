<?php

namespace Framework\Renderer;

use Psr\Container\ContainerInterface;

/**
 * class factory twig for the renderer use in the depedency container
 * to instanciate twig renderer with the view path config
 */
class TwigRendererFactory
{
    public function __invoke(ContainerInterface $container): TwigRenderer
    {
        //retrieve view_path from caontainer
        $viewPath = $container->get('view_path');

        //instantiate loader
        $loader = new \Twig\Loader\FilesystemLoader($viewPath);

        //instantaite twig with loader
        $twig = new \Twig\Environment($loader);


        //instantiate tigrenderer
        return new TwigRenderer($twig);
    }
}
