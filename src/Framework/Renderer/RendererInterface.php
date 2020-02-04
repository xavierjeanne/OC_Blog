<?php

namespace Framework\Renderer;

/**
 * render class
 */
interface RendererInterface
{


    /**
     * add path to load view
     *
     * @param string $namespace
     * @param string|null $path
     * @return void
     */
    public function addPath(string $namespace, ?string $path = null): void;


    /**
     * render the view corresponding to path with params of request
     * path can be precise with namesapce add with addPath
     * $this->render('@blog/view');
     * $this->render('view');
     * @param  mixed $view
     * @param  mixed $params
     *
     * @return string
     */
    public function render(string $view, array $params = []): string;

    /**
     * add variable global to all view
     * @param string $key
     * @param mixed $value
     * @return boolean
     */
    public function addGlobal(string $key, $value): void;
}
