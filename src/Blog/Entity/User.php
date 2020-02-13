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

    public function __construct()
    {
        $this->avatar = dirname(__DIR__) . '/public/img/avatar/anonymous.png';
    }
}
