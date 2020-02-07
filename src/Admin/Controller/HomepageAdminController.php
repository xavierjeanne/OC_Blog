<?php

namespace App\Admin\Controller;

use App\Blog\Repositories\PostRepository;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomepageAdminController
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    private $postRepository;

    public function __construct(RendererInterface $renderer, PostRepository $postRepository)
    {
        $this->renderer = $renderer;
        $this->postRepository = $postRepository;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        return $this->renderer->render('@admin/index');
    }
}
