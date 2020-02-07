<?php

namespace App\Admin\Controller;

use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomepageAdminController
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    private $postRepository;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $this->renderer->render('@admin/index');
    }
}
