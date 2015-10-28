<?php

namespace Blog\Model;

use Framework\Model\ActiveRecord;
use Framework\Security\Model\UserInterface;
use Framework\DI\Service;

/**
 * Class User
 * @package Blog\Model
 * @author JuraZubach
 * @since 1.0
 */
class User extends ActiveRecord implements UserInterface
{
    public $id;
    public $email;
    public $password;
    public $role;

    public static function getTable()
    {
        return 'users';
    }

    public function getRole()
    {
        return $this->role;
    }
}