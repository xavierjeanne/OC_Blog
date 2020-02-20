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

        //if container has twig extensions foreach extension add extension to twigRenderer
        if ($container->has('twig.extensions')) {
            foreach ($container->get('twig.extensions') as $extension) {
                $twig->addExtension($extension);
            }
        }

        //instantiate tigrenderer
        return new TwigRenderer($twig);
    }
}
