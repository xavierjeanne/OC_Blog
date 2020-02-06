<?php

namespace App\Blog\Controllers;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomepageController
{
    /**
     *
     * @var RendererInterface
     */
    private $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request):void
    {
        return $this->renderer->render('@blog/index');
    }
}
