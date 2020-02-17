<?php

namespace App\Blog\Repository;

use Framework\Repository\Repository;
use App\Blog\Entity\Post;
use App\Blog\Repository\UserRepository;

class PostRepository extends Repository
{
    /**
     * @var Post
     */
    protected $entity = Post::class;

    /**
     * @var string
     */
    protected $repository = 'posts';

    protected function countQuery():string
    {
        return "SELECT COUNT(id) FROM  $this->repository WHERE status ='published'";
    }

    protected function paginationQuery():string
    {
        return "SELECT *  FROM  $this->repository as p INNER JOIN users as u ON p.user_id = u.id WHERE p.status ='published' ORDER BY p.created_at DESC";
    }
}
