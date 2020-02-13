<?php

namespace App\Blog\Entity;

class Comment
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var text
     */
    public $comment;

    /**
     * @var int
     */
    public $userId;

    /**
     *
     * @var int
     */
    public $postId;

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

    public function __construct()
    {
        //format date
        $this->created_at = new \DateTime($this->created_at);
        $this->updated_at = new \DateTime($this->updated_at);
    }
}
