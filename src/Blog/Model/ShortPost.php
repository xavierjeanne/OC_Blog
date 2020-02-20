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
        $ShortPost = new self();
        $ShortPost->title = $row['title'];
        $ShortPost->id = $row['id'];
        $ShortPost->abstract = $row['abstract'];
        $ShortPost->picture = $row['picture'];
        $ShortPost->autorUsername = $row['login'];
        $ShortPost->createdAt = new \Datetime($row['created_at']);

        if ($ShortPost->picture === null) {
            $ShortPost->picture = '/img/picture/default.png';
        }

        return $ShortPost;
    }
}
