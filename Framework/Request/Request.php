<?php

namespace Framework\Request;

use Framework\Response\ResponseRedirect;
use Framework\Router\Router;

/**
 * Class Request represents an HTTP request.
 *
 * @package Framework\Request
 * @author JuraZubach
 * @since 1.0
 */
class Request
{
    private $post;
    private $get;
    private $cookies;
    private $host;
    private $uri;
    private $script;
    private $params;
    private $method;
    private $ajax;

    public function __construct(){
        $this->post = $_POST;
        $this->get = $_GET;
        $this->cookies = $_COOKIE;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->host = $_SERVER['SERVER_NAME'];
        $this->uri = $_SERVER['REQUEST_URI'];
        $this->script = $_SERVER['SCRIPT_NAME'];
        $this->params = $_SERVER['QUERY_STRING'];
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Return option types 'mindkblog.com'.
     *
     * @return mixed
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Return necessary information from request.
     *
     * @param $name
     * @return bool|mixed|string
     */
    public function getRequestInfo($name)
    {
        return $this->filter($this->$name);
    }


    /**
     * Return option types '/'.
     *
     * @return mixed
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Return option types 'GET'.
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Return option types '/index.php'.
     *
     * @return mixed
     */
    public function getScript()
    {
        return $this->script;
    }

    /**
     * Return true or false, if getMethod() == 'GET'.
     *
     * @return bool
     */
    public function isGet()
    {
        if ($this->method == 'GET') {
            return true;
        }else{
            return false;}
    }

    /**
     * Return true or false, if getMethod() == 'POST'.
     *
     * @return bool
     */
    public function isPost()
    {
        if ($this->method == 'POST') {
            return true;
        }else{
            return false;}
    }

    /**
     * Filters in GET method input.
     *
     * @param $param
     * @return bool|mixed|null|string
     */
    public function get($param){
        if(array_key_exists($param, $_GET))
            return $this->filter($_GET[$param]);
        return null;
    }

    /**
     * Filters in GET method input.
     *
     * @param $param
     * @return bool|mixed|null|string
     */
    public function post($param){
        if(array_key_exists($param, $_POST))
            return $this->filter($_POST[$param]);
        return NULL;
    }

    /**
     * Filter for input data.
     *
     * @param $method
     * @return bool|mixed|string
     */
    public function filter($method){
        if (strlen($method)){
            $result = trim($method);
            $result = preg_replace('/<\s*\/*\s*\w*>|[\$`~#<>\[\]\{\}\\\*\^%]/', "", $result);
        } else {
            return false;
        }
        return $result;
    }

    /**
     * @param mixed $params
     * @return Request
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * AJAX check.
     *
     * @return bool
     */
    public function isAjax(){
        if($this->ajax !==  null){
            return $this->ajax;
        }
        if(
            isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
        ) {
            return $this->ajax = true;
        } else {
            return $this->ajax = false;
        }
    }

}