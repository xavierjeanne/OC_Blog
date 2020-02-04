<?php

namespace App\Blog\Controller;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController
{
    /**
     *
     * @var RendererInterface
     */
    private $renderer;



    /**
     * constructor
     *
     * @param RendererInterface $renderer
     */
    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * invoke the method corresponding to request
     *
     * @param ServerRequestInterface $request
     * @return void
     */
    public function __invoke(ServerRequestInterface $request)
    {
        return  $this->index($request);
    }

    /**
     * show all article
     *
     * @return string
     */
    public function index(ServerRequestInterface $request): string
    {
        return $this->renderer->render('@blog/index');
    }
}
