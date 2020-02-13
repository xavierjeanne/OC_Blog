<?php

namespace App\Blog\Repository;

use Framework\Repository\Repository;
use App\Blog\Entity\Post;
use App\Blog\Repository\UserRepository;

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

    /**
     * get count query
     *
     * @return string
     */
    protected function countQuery()
    {
        return "SELECT COUNT(id) FROM  $this->repository WHERE status ='published'";
    }

    /**
     * get pagination query
     *
     * @return string
     */
    protected function paginationQuery()
    {
        $users = new UserRepository($this->pdo);
        $userRepository=$users->getRepository();
        return "SELECT p.id as postId,p.*,u.* FROM  $this->repository as p INNER JOIN $userRepository as u ON p.user_id=u.id WHERE p.status ='published' ORDER BY p.created_at DESC";
    }

     /**
     * get a post with id
     *
     */
    public function find(int $id)
    {
        $users = new UserRepository($this->pdo);
        $userRepository=$users->getRepository();
        $query = $this->pdo->prepare("SELECT * FROM $this->repository as p INNER JOIN $userRepository as u ON p.user_id=u.id  WHERE p.id=?");
        $query->execute([$id]);
        $query->setFetchMode(\PDO::FETCH_CLASS, $this->entity);
        return $query->fetch() ?: null;
    }
}
