<?php

namespace App\Blog\Repository;

use App\Blog\Entity\Post;
use App\Blog\Model\ShowPost;
use App\Blog\Model\ShortPost;
use Framework\Repository\Repository;
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
    protected $table = 'posts';

    /**
     *
     * @var ShortPost
     */
    protected $model = ShortPost::class;

    protected function countQuery(): string
    {
        return "SELECT COUNT(id) FROM  $this->table WHERE status ='published'";
    }

    protected function paginationQuery(): string
    {
        return "SELECT p.id as postId,p.picture,p.created_at,p.abstract,p.title,u.login 
        FROM  $this->table as p 
        INNER JOIN users as u 
        ON p.user_id = u.id 
        WHERE p.status ='published' 
        ORDER BY p.created_at DESC";
    }

    public function find(int $id)
    {
        $query = $this->pdo->prepare(
            "SELECT p.picture,p.created_at,p.abstract,p.title,p.content,u.login 
            FROM  $this->table as p 
            INNER JOIN users as u 
            ON p.user_id = u.id 
            WHERE p.id=?"
        );
        $query->execute([$id]);
        $result = $query->fetch();

        if ($result) {
            $item = ShowPost::createFromRow($result);
            return $item;
        }

        return $result;
    }
}
