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
    public $created_at;

    /**
     * @var datetime
     */
    public $updated_at;

    /**
     * @var int
     */
    public $userId;

    public function __construct()
    {
        $this->created_at = new \Datetime($this->created_at);
        $this->updated_at = new \DateTime($this->updated_at);
        $this->picture = '/img/picture/default.png';
    }
}
