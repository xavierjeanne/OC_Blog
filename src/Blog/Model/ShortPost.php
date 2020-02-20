<?php

namespace App\Blog\Model;

class ShortPost
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
     * @var string
     */
    public $picture;

    /**
     * @var datetime
     */
    public $createdAt;

    /**
     * @var int
     */
    public $autorUsername;

    public static function createFromRow(array $row): ShortPost
    {
        $shortPost = new self();
        $shortPost->title = $row['title'];
        $shortPost->id = $row['postId'];
        $shortPost->abstract = $row['abstract'];
        $shortPost->picture = $row['picture'];
        $shortPost->autorUsername = $row['login'];
        $shortPost->createdAt = new \Datetime($row['created_at']);

        if ($shortPost->picture === null) {
            $shortPost->picture = '/img/picture/default.png';
        }

        return $shortPost;
    }
}
