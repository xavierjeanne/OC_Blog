<?php

namespace App\Blog\Controller;

use App\Blog\Repository\PostRepository;
use Framework\Renderer\RendererInterface;
use Framework\Router;
use Psr\Http\Message\ServerRequestInterface;

class PostShowController
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var PostRepository
     */
    private $postRepository;

    /**
     * @var Router
     */
    private $router;

    public function __construct(RendererInterface $renderer, PostRepository $postRepository, Router $router)
    {
        $this->renderer = $renderer;
        $this->postRepository = $postRepository;
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        //use method find of postTable with id send
        $item = $this->postRepository->find($request->getAttribute('id'));

        if (empty($item)) {
            return $this->router->redirect('blog.index');
        }

        //return render with the namespace @blog for show and send post to view
        return $this->renderer->render('@blog/show', ['item' => $item]);
    }
}
