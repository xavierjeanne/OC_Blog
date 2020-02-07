<?php

namespace App\Blog\Entities;

/**
 * entity class, represent a entity user in database
 */
class User
{
    /**
     * @var int id
     */
    public $id;

    /**
     * @var string name
     */
    public $name;

    /**
     * @var string first_name
     */
    public $first_name;

    /**
     * @var string login
     */
    public $login;

    /**
     * @var string password
     */
    public $password;

    /**
     * @var string email
     */
    public $email;

    /**
     * @var string avatar
     */
    public $avatar;

    /**
     * @var enum status
     * @options=["visitor","admin"]
     */
    public $status;

    public function __construct()
    {
        if (is_null($this->avatar)) {
            $this->avatar = dirname(__DIR__) . '/public/img/avatar/anonymous.png';
        }
    }
}
