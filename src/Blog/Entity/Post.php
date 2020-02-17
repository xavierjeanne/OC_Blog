<?php

namespace App\Blog\Entity;

class Post
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $title;

    /**
     * @var string
     */
    public $abstract;

    /**
     * @var text
     */
    public $content;

    /**
     * @var string
     */
    public $picture;

    /**
     * @var enum
     * @options=["draft","published"]
     */
    public $status;

    /**
     * @var datetime
     */
    public $createdAt;

    /**
     * @var datetime
     */
    public $updatedAt;

    /**
     * @var int
     */
    public $userId;

    /**
     * @var string
     */
    public $userLogin;

    public static function createFromRow(array $row): Post
    {
        $post = new self();
        $post->title = $row['title'];
        $post->id = $row['id'];
        $post->abstract = $row['abstract'];
        $post->content = $row['content'];
        $post->userId = $row['user_id'];
        $post->userLogin = $row['login'];
        $post->picture = $row['picture'];
        $post->status = $row['status'];
        $post->createdAt = new \Datetime($row['created_at']);
        $post->updatedAt = new \Datetime($row['updated_at']);
        if ($post->picture === null) {
            $post->picture='/img/picture/default.png';
        }
        return $post;
    }
}
