<?php

namespace Framework\Renderer;

use Framework\DI\Service;

/**
 * Renderer is the base class for view renderer classes.
 *
 * @package Framework\Renderer
 * @author JuraZubach
 * @since 1.0
 */
class Renderer
{
    protected $layout;

    protected $data = array();

    /**
     * Takes a real path file and data.
     *
     * @param $view
     * @param $data
     */
    public function __construct($view, $data)
    {
        $this->layout = $view;
        $this->data = $data;
    }

    /**
     * Include HTML layout file and extract data.
     *
     * @return string
     */
    public function render()
    {

        $getRoute = function($rout, $params = null) {
            $router = Service::get('route');

            return $router->buildRoute($rout, $params);
        };

        $user = Service::get('session')->get('authenticated');
        $route = Service::get('route')->findRoute();

        $generateToken = function(){
            $token = Service::get('security')->generateToken();
            echo '<input type = "hidden" name = "token" value = "'.$token.'">';
        };

        $data['getRoute'] = $getRoute;
        $data['generateToken'] = $generateToken;

        ob_start();
        extract($this->data);
        include($this->layout);
        return ob_get_clean();
    }
}