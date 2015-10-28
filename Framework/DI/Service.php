<?php

namespace Framework\DI;

use Framework\Exception\ServiceNotFoundException;

/**
 * Class Service is a dependency injection container.
 * It gives access to object instances (services).
 * Services and parameters are simple key/pair stores.
 *
 * @package Framework\DI
 * @author JuraZubach
 * @since 1.0
 */
class Service
{
    private static $instance = null;
    private static $services = array();

    private function __construct()
    {
        //...
    }

    /**
     * Returns the singleton instance of the class
     */
    public static function getInstance()
    {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
    }

    public function __clone()
    {
        //...
    }

    /**
     * Specifies the service.
     *
     * @param $service_name
     * @param $obj
     */
    public static function set($service_name, $obj){
        try
        {
            if (!array_key_exists($service_name, self::$services)){
                self::$services[$service_name] = $obj;
            } else {
                throw new ServiceNotFoundException('Service can not load - '.$service_name.''.$obj);
            }
        } catch (ServiceNotFoundException $e)
        {
            echo 'ERROR:'.$e->getMessage();
        }
    }

    /**
     * Gets the service.
     *
     * @param $service_name
     * @return mixed
     * @throws ServiceNotFoundException
     */
    public static function get($service_name){
        try
        {
            if (array_key_exists($service_name, self::$services)){
                return self::$services[$service_name];
            } else {
                throw new ServiceNotFoundException('Service not found - '.$service_name);
            }
        } catch (ServiceNotFoundException $e)
        {
            echo 'ERROR: '.$e->getMessage();
        }
    }
}