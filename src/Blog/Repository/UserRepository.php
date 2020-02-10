<?php

namespace App\Blog\Repository;

use App\Blog\Entity\User;
use Framework\Repository\Repository;

class UserRepository extends Repository
{
    /**
     * @var Post
     */
    protected $entity = User::class;

    /**
     * @var string
     */
    protected $repository = 'users';
}
