<?php

namespace Framework\Controller;

use Framework\Request\Request;
use Framework\Response\Response;
use Framework\DI\Service;
use Framework\Renderer\Renderer;
use Framework\Response\ResponseRedirect;

/**
 * Controller is the base class of web controllers.
 *
 * @package Framework\Controller
 * @author JuraZubach
 * @since 1.0
 */
abstract class Controller
{
    /**
     * Render full path to $layout. Finally '/var/www/mindkblog.com/src/Blog/views/Post/index.html.php'.
     *
     * @param $layout
     * @param null $data
     * @return Response
     */
    public function render($layout, $data = null)
    {
        $controller_class = get_class($this);
        $segments = explode('\\', $controller_class);
        $root_namespace = array_shift($segments);
        $path_to_pkg = \Loader::getPath($root_namespace);
        $ctrl = array_pop($segments);
        $view_dir_name = str_replace('Controller','', $ctrl);

        $layout_full_path = realpath($path_to_pkg.'/views/'.$view_dir_name.'/'.$layout.'.php');
        $renderer = new Renderer($layout_full_path, $data);
        $response = new Response($renderer->render());

        return $response;
    }

    /**
     * Get Request service.
     *
     * @return Request
     */
    public function getRequest()
    {
        return Service::get('request');
    }


    /**
     * Redirect to $url with flash msg(type and msg).
     *
     * @param $url
     * @param null $type
     * @param null $msg
     * @return ResponseRedirect
     */
    public function redirect($url, $type = null, $msg = null)
    {
        $flushmsg=Service::get('session');
        $flushmsg->setFlush($type, $msg);

        $redirect = new ResponseRedirect($url);
        $redirect->send();
    }

    /**
     * Generate route, type 'home' and params.
     *
     * @param $name
     * @param array $params
     * @return mixed
     */
    public function generateRoute($name, $params = array())
    {
        $router = Service::get('route');

        return $router->buildRoute($name, $params);
    }
}