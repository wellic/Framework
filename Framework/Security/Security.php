<?php

namespace Framework\Security;

use Framework\DI\Service;
use Framework\Model\ActiveRecord;
use Framework\Security\Model\UserInterface;

/**
 * Class Security
 *
 * @package Framework\Security
 * @author JuraZubach
 * @since 1.0
 */
class Security extends ActiveRecord implements UserInterface
{
    public $role;
    protected $session;

    public function __construct()
    {
        $this->session = Service::get('session');
    }

    /**
     * Checks if the user is authorized.
     *
     * @return bool
     */
    public function isAuthenticated()
    {
        if ($this->session->get('authenticated'))
        {
            return $this->session->get('authenticated');
        } else {
            return false;
        }
    }

    /**
     * Authorized user.
     *
     * @param $user
     */
    public function setUser($user)
    {
        $this->session->set('authenticated', $user);
    }

    /**
     * Gets is authorized user.
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->session->get('authenticated');
    }

    /**
     * Remove authorized session user.
     */
    public function clear()
    {
        $this->session->unsetSession('authenticated');
    }

    /**
     * Return user role.
     *
     * @return mixed
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Generates a new token, means md5.
     *
     * @return string
     */
    public function generateToken()
    {
        if (Service::get('session')->get('token'))
        {
            return Service::get('session')->get('token');
        } else {
            $token = md5(Service::get('session')->getID());
            setcookie('token', $token);
            Service::get('session')->set('token', $token);
        }
    }

    /**
     * Checks if this token the user in the cookie.
     *
     * @return bool
     */
    public function checkToken()
    {
        $token = (Service::get('request')->post('token')) ? Service::get('request')->post('token') : null;
        if(!is_null($token))
        {
            return ($token == $_COOKIE['token']) ? true : false ;
        } else {
            return true;
        }
    }
}