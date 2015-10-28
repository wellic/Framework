<?php

namespace Framework\Session;

/**
 * Class Session provides session data management and the related configurations.
 *
 * @package Framework\Session
 * @author JuraZubach
 * @since 1.0
 */
class Session
{
    private  $lifetime = 14400;
    private  $cookieName = "ua";
    public  $returnUrl = null;

    public  function __construct()
    {
        $this->start();
    }

    /**
     * ReturnURL.
     *
     * @param $url
     */
    public function setReturnUrl($url)
    {
        if (!strpos($url, 'login'))
        {
            $this->set('returnUrl',$url);
        }
        $this->returnUrl = $this->get('returnUrl');
    }

    /**
     * Sets flash messages with type.
     *
     * @param $type
     * @param $msg
     */
    public function setFlush($type, $msg)
    {
        if(isset($msg))
        {
            $session = $this->get('flush');
            $session[$type][] = $msg;
            $this->set('flush', $session);
        }
    }

    /**
     * Get flash messages array.
     *
     * @return array|null
     */
    public function getFlush()
    {
        $flushMsg = $this->get('flush');
        if($flushMsg === NULL)
        {
            $flushMsg = array();
        } else {
            $this->delete('flush');
        }

        return $flushMsg;

    }

    /**
     * Start sessions engine.
     */
    public function start()
    {
        session_set_cookie_params ($this->lifetime + time(), '/');
        session_name($this->cookieName);
        session_start();
    }

    /**
     * Set name and value in SESSION.
     *
     * @param $name
     * @param $value
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Get name and value in SESSION.
     *
     * @param $name
     * @return null
     */
    public function get($name)
    {
        return empty($_SESSION[$name]) ? NULL : $_SESSION[$name];
    }

    /**
     * Remove session.
     */
    public function destroy()
    {
        session_destroy();
    }

    /**
     * Gets session_id.
     *
     * @return string
     */
    static public function getId()
    {
        return session_id();
    }

    /**
     * Gets name session.
     *
     * @return string
     */
    static public function getName()
    {
        return session_name();
    }

    /**
     * Remove name in SESSION.
     *
     * @param $name
     * @return bool
     */
    public function unsetSession($name)
    {
        if(isset($_SESSION[$name]))
        {
            unset($_SESSION[$name]);
            return true;
        }
        return false;
    }
}