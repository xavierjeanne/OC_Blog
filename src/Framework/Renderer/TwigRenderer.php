<?php

namespace Framework\Renderer;

use Twig\Environment;

class TwigRenderer implements RendererInterface
{
    /**
     * @var Twig
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * render the view corresponding to path with params of request
     * path can be precise with namesapce add with addPath
     * $this->render('@blog/view');
     * $this->render('view');
     * @param string $view
     * @param array $params
     * @return string
     */
    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.html.twig', $params);
    }

    /**
     * add path to load view
     *
     * @param string $namespace
     * @param string|null $path
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->twig->getLoader()->addPath($path, $namespace);
    }

    /**
     * add variable global to all view
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }
}
