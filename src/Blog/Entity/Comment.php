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
     public $createdAt;

     /**
      * @var datetime
      */
     public $updatedAt;

     public static function createFromRow(array $row): Comment
     {
          $comment = new self();
          $comment->id = $row['id'];
          $comment->comment = $row['comment'];
          $comment->userId = $row['user_id'];
          $comment->postId = $row['post_id'];
          $comment->status = $row['status'];
          $comment->createdAt = new \Datetime($row['created_at']);
          $comment->updatedAt = new \Datetime($row['updated_at']);

          return $comment;
     }
}
