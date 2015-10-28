<?php

namespace Framework\Router;

use Framework\DI\Service;
use Framework\Exception\RouteException;

/**
 * Class Router represents a collection of URL rules sharing the same prefix in their patterns and routes.
 *
 * @package Framework\Router
 * @author JuraZubach
 * @since 1.0
 */
class Router
{
    protected $routing_map = array();
    protected $request;

    /**
     * Takes an array with a map of the routes.
     *
     * @param array $map
     */
    public function __construct($map = array()){
        $this->routing_map = $map;
        $this->request = Service::get('request');
    }

    /**
     * Pattern for filters data, by means of regular expressions.
     *
     * @param array $route
     * @return array
     */
    private function patternToRegexp($route = array())
    {
        $pattern = '/\{[\w\d_]+\}/Ui';
        preg_match_all($pattern, $route['pattern'], $matches);
        foreach ($matches[0] as $value){
            if(array_key_exists(trim($value, '{}'), $route['_requirements'])) {
                $replacement[] = '('.$route['_requirements'][trim($value, '{}')].')';
            }
        }
        $str = str_replace($matches[0], $replacement, $route['pattern']);

        return array($str, $matches[0]);
    }

    /**
     * Find routes based on the URI.
     *
     * @return mixed
     * @throws RouteException
     */
    public function findRoute()
    {
        $uri = $this->request->getUri();
        if(!is_null($this->routing_map))
        {
            foreach($this->routing_map as $key => $value)
            {
                if(strpos($value['pattern'], '{'))
                {
                    $result = $this->patternToRegexp($value);
                    $pattern = $result[0];
                    $vars = $this->getVars($pattern, $result[1], $uri);
                } else {
                    $pattern = $value['pattern'];
                }
                if(preg_match('~^'.$pattern.'$~', $uri))
                {
                    $route = $value;
                    break;
                }
            }

            if(!empty($route))
            {
                $route['_name'] = $key;
                if(!empty($vars)) $route['vars'] = $vars;
                return $route;
            }
        }
    }


    /**
     * Builds a route based on route maps and returns a URI.
     *
     * @param $name
     * @param $params
     * @return mixed|string
     */
    public function buildRoute($name, $params = null){
        $url = '';
        if(array_key_exists($name, $this->routing_map)){
            $url = $this->routing_map[$name]['pattern'];
            if($params){
                foreach($params as $key=>$value){
                    $url = str_replace('{'.$key.'}', $value, $url);
                }
            }

            $url = preg_replace('~\{[\w\d_]+\}~iU', '', $url);
        }

        return $url;
    }

    /**
     * Processes the parameters and returns an array.
     *
     * @param $pattern
     * @param $keys
     * @param $uri
     * @return array
     */
    private function getVars($pattern, $keys, $uri){
        $vars = array();
        preg_match('~'.$pattern.'~i', $uri, $matches);
        foreach ($keys as $key=>$value){
            if (isset($matches[$key+1])){
                $vars[trim($value, '{}')] = $matches[$key+1];
            }
        }

        return $vars;
    }


}