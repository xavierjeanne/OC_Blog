<?php

namespace App\Blog\Entities;

/**
 * entity class, represent a entity post in database
 */
class Post
{
    /**
     *
     * @var int id
     */
    public $id;

    /**
     * @var string title
     */
    public $title;

    /**
     * @var text content
     */
    public $content;

    /**
     *
     * @var string picture
     */
    public $picture;

    /**
     * @var enum status
     * @options=["draft","published"]
     */
    public $status;

    /**

     * @var int user_id
     */
    public $user_id;

    /**
     * @var datetime created_at
     */
    public $created_at;

    /**
     * @var datetime updated_at
     */
    public $updated_at;

    public function __construct()
    {
        //format date
        if ($this->created_at) {
            $this->created_at = new \DateTime($this->created_at);
        }

        //format date
        if ($this->updated_at) {
            $this->updated_at = new \DateTime($this->updated_at);
        }

        //define picture by default
        if (is_null($this->picture)) {
            $this->picture = dirname(__DIR__) . '/public/img/picture/default.png';
        }
    }
}
