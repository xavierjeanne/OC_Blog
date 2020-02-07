<?php

namespace App\Blog\Repositories;

use Framework\Repository;
use App\Blog\Entities\Post;

/**
 * method use for management PostRepository
 */
class PostRepository extends Repository
{
    /**
     * Undocumented variable
     *
     * @var Post
     */
    protected $entity = Post::class;

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $repository = 'posts';
}
