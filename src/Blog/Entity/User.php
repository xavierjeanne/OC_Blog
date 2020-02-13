<?php

namespace App\Blog\Entity;

class User
{
     /**
      * @var int
      */
     public $id;

     /**
      * @var string
      */
     public $name;

     /**
      * @var string
      */
     public $firstName;

     /**
      * @var string
      */
     public $login;

     /**
      * @var string
      */
     public $password;

     /**
      * @var string
      */
     public $email;

     /**
      * @var string
      */
     public $avatar;

     /**
      * @var enum
      * @options=["visitor","admin"]
      */
     public $status;

     public static function createFromRow(array $row): User
     {
          $user = new self();
          $user->id = $row['id'];
          $user->name = $row['name'];
          $user->firstName = $row['first_name'];
          $user->login = $row['login'];
          $user->password = $row['password'];
          $user->avatar = $row['avatar'];
          $user->status = $row['status'];

          if ($user->avatar === null) {
               $user->avatar = '/img/avatar/anonymous.png';
          }

          return $user;
     }
}
