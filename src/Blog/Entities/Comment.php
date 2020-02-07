<?php

namespace App\Blog\Entities;

/**
 * entity class, represent a entity comment in database
 */
class Comment
{
    /**
     *
     * @var int id
     */
    public $id;

    /**
     * @var text comment
     */
    public $comment;

    /**
     * @var int user_id
     */
    public $user_id;

    /**
     *
     * @var int post_id
     */
    public $post_id;

    /**
     * @var enum status
     * @options=["draft","published"]
     */
    public $status;


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
    }
}
