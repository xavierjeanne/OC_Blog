<?php

namespace App\Blog\Model;

class ShowPost
{
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
     * @var text
     */
    public $content;

    /**
     * @var datetime
     */
    public $createdAt;

    /**
     * @var int
     */
    public $autorUsername;

    public static function createFromRow(array $row): ShowPost
    {
        $showPost = new self();
        $showPost->title = $row['title'];
        $showPost->abstract = $row['abstract'];
        $showPost->picture = $row['picture'];
        $showPost->content = $row['content'];
        $showPost->autorUsername = $row['login'];
        $showPost->createdAt = new \Datetime($row['created_at']);

        if ($showPost->picture === null) {
            $showPost->picture = '/img/picture/default.png';
        }

        return $showPost;
    }
}
