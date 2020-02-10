<?php

namespace App\Blog\Repository;

use App\Blog\Entity\Comment;
use Framework\Repository\Repository;

class CommentRepository extends Repository
{
    /**
     * @var Post
     */
    protected $entity = Comment::class;

    /**
     * @var string
     */
    protected $repository = 'comments';
}
