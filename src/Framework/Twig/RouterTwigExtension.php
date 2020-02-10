<?php

namespace Framework\Twig;

use Framework\Router;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

/**
 * twig extension class for router, create a router fontion to use in navigation
 */
class RouterTwigExtension extends AbstractExtension
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }
   
    public function getFunctions():array
    {
        return [
            new TwigFunction('path', [$this, 'pathFor']),
        ];
    }

    public function pathFor(string $path, array $params = []): string
    {
        return $this->router->generateUri($path, $params);
    }
}
