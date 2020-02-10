<?php

namespace App\Blog\Controller;

use App\Blog\Repositories\PostRepository;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class PostShowController
{
    /**
     *
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
        //use method find of postTable with id send
        $item = $this->postRepository->find($request->getAttribute('id'));
        //if result empty use trait routerawareaction and redirect
        if (empty($item)) {
            return $this->redirect('blog.index');
        }
        //return render with the namespace @blog for show and send post to view
        return $this->renderer->render('@blog/show', compact('item'));
    }
}
