<?php

namespace Framework\Renderer;

interface RendererInterface
{
    /**
     * add path to load view
     */
    public function addPath(string $namespace, ?string $path = null): void;

    /**
     * render the view corresponding to path with params of request
     * path can be precise with namesapce add with addPath
     * $this->render('@blog/view');
     * $this->render('view');
     *
     */
    public function render(string $view, array $params = []): string;

    /**
     * add variable global to all view
     */
    public function addGlobal(string $key, $value): void;
}
