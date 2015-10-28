<?php

namespace Framework;

use Framework\Database\QueryConnect;
use Framework\DI\Service;
use Framework\Exception\HttpNotFoundException;
use Framework\Exception\RouteException;
use Framework\Response\ResponseRedirect;
use Framework\Session\Session;
use Framework\Router\Router;
use Framework\Request\Request;
use Framework\Response\Response;
use Framework\Renderer\Renderer;
use Framework\Exception\BadResponseException;
use Framework\Security\Security;

/**
 * Class Application
 *
 * @package Framework
 * @author JuraZubach
 * @since 1.0
 */
class Application
{
    private $config = array();

    /**
     * Plug-in configuration file, and added to the service container
     * such services: database connection, config, session, security, request and app.
     *
     * @param $cfg
     */
    public function __construct($cfg)
    {
        if(file_exists($cfg) && is_readable($cfg))
        {
            $this->config = include($cfg);
        }

        new QueryConnect($this->config['pdo']);
        Service::set('database', QueryConnect::getDatabase());

        Service::set('config', $this->config);
        Service::set('session', new Session());
        Service::set('security', new Security());
        Service::set('request', new Request());
        Service::set('app', $this);
    }

    /*
    |--------------------------------------------------------------------------
    | Run The Application
    |--------------------------------------------------------------------------
    |   Find in the routing map the routes existing route.
    |   If the route was found to have 'security' that makes the verification role,
    |   on the accessibility to this action, or redirected to '/login'.
    |
    |   Check whether there is such a class and create its object. Define active and vars.
    |
    |   By means of Reflection, we check if this controller, we need a method, and whether the specified options.
    |   In the $response variable caused by we need a method with parameters.
    |
    |   If we have flash message, write it in the session and after being cleaned.
    |
    |   Check whether $response the required Response functions.
    |
    |   If the $response type is 'html', then include the main layout and rendering with a flash message,
    |   then create an object of class Response with the desired content. And sent to the client.
    */
    public function run()
    {
        Service::get('security')->generateToken();
        if (!Service::get('security')->checkToken())
        {
            die('Token not exist');
        }

        $map = $this->config['routes'];
        Service::set('route', new Router($map));
        $match_route = Service::get('route');
        $route = $match_route->findRoute();

        if(!empty($route['security'])){
            $user = Service::get('session')->get('authenticated');
            if (is_object($user)) {
                $user_role = get_object_vars($user);
            }
            if(!empty($user_role['role'] !== 'ROLE_ADMIN')){
                $msg = 'Access Denied! Only the administrator can create new posts.';
                $fsg = Service::get('session');
                $fsg->setFlush('error', $msg);
                $redirect = new ResponseRedirect(Service::get('route')->buildRoute($this->config['security']['login_route']));
                $redirect->send();
            }
        }

        try
        {
            if (class_exists($route['controller']))
            {
                $controller = new $route['controller'];
                $action = $route['action'].'Action';
                if(isset($route['vars']))
                {
                    $vars = $route['vars'];
                }
                $controller_reflection = new \ReflectionClass($route['controller']);
                if ($controller_reflection->hasMethod($action))
                {
                    $method = new \ReflectionMethod($controller, $action);
                    $params = $method->getParameters();
                    if(empty($params))
                    {
                        $response = $method->invoke(new $controller);
                    } else {
                        $response = $method->invokeArgs(new $controller, $vars);
                    }
                }
            } else {
                throw new HttpNotFoundException('Oops, Not Found', 404);
            }
        } catch (HttpNotFoundException $e) {
            $error_layout = $this->config['error_500'];
            $renderer = new Renderer($error_layout, array('message' => $e->getMessage(), 'code' => $e->getCode()));
            $response = new Response($renderer->render());
        }

        $flush = (Service::get('session')->get('flush')) ? Service::get('session')->get('flush') : array();
        Service::get('session')->unsetSession('flush');

        Service::get('session')->setReturnUrl(Service::get('request')->getRequestInfo('uri'));

        try
        {
            if ($response instanceof Response){
                if ($response->type == 'html'){
                    $view = $this->config['main_layout'];
                    $renderer = new Renderer($view, array('content' => $response->getContent(), 'flush' => $flush));
                    $wrapped = $renderer->render();
                    $response = new Response($wrapped);
                }
                $response->send();
            } else {
                throw new BadResponseException('Bad response', 500);
            }
        } catch (BadResponseException $e)
        {
            echo $e->getMessage();
        }
    }
}