<?php

namespace App\Blog\Controller;

use App\Blog\Repository\PostRepository;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ServerRequestInterface;

class BlogController
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
        //get params of pagination if exist
        $params = $request->getQueryParams();
        //get posts ,use method find paginated published (only post published)
        $items = $this->postRepository->findPaginated(5, $params['p'] ?? 1);

        //return render with the namespace @blog for index with posts
        return $this->renderer->render('@blog/blog', compact('items'));
    }
}
