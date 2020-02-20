<?php

namespace Framework\Twig;

use Framework\Router;
use Twig\TwigFunction;
use Pagerfanta\Pagerfanta;
use Twig\Extension\AbstractExtension;
use Pagerfanta\View\TwitterBootstrap4View;

class PagerFantaExtension extends AbstractExtension
{
    /**
     * @var Router
     */
    private $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('paginate', [$this, 'paginate'], ['is_safe' => ['html']]),
        ];
    }

    public function paginate(
        Pagerfanta $paginatedResults,
        string $route,
        array $routerParams = [],
        array $queryArgs = []
    ): string {
        //create view bootstrap paginator
        $view = new TwitterBootstrap4View();
        $options = [
            'prev_message' => '&larr; Précédent',
            'next_message' => 'Suivant &rarr;',
        ];

        //create render pagerfanta
        return $view->render($paginatedResults, function (int $page) use ($route, $routerParams, $queryArgs) {

            if ($page > 1) {
                $queryArgs['p'] = $page;
            }

            //generate url with route and parametre p and current page
            return $this->router->generateUri($route, $routerParams, $queryArgs);
        }, $options);
    }
}
