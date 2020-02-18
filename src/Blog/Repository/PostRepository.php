<?php

namespace App\Blog\Repository;

use App\Blog\Entity\Post;
use App\Blog\Model\ShortPost;
use Framework\Repository\Repository;

class PostRepository extends Repository
{
    /**
     * @var ShortPost
     */
    protected $model = ShortPost::class;

    /**
     * @var string
     */
    protected $table = 'posts';

    protected function countQuery(): string
    {
        return "SELECT COUNT(id) FROM  $this->table WHERE status ='published'";
    }

    protected function paginationQuery(): string
    {
        return "SELECT *  FROM  $this->table as p INNER JOIN users as u ON p.user_id = u.id WHERE p.status ='published' ORDER BY p.created_at DESC";
    }
}
