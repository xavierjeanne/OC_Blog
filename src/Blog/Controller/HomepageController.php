<?php

namespace App\Blog\Controller;

use App\Blog\Repositories\PostRepository;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class HomepageController
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
        //get posts ,use method find all
        $posts = $this->postRepository->findAll();
        //return render with the namespace @blog for index with posts
        return $this->renderer->render('@blog/index', compact('posts'));
    }
}
