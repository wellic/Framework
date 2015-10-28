<?php

use Framework\Exception\ClassNotFoundException;
use Framework\Exception\NamespaceException;

/**
 * Class Loader implements an PSR-4 class loader.
 *
 * @author JuraZubach
 * @since 1.0
 */
class Loader
{
    private static $_instance;

    private $namespaces = array();

    private function __construct()
    {
        //...
    }

    private function __clone()
    {
        //...
    }

    /**
     * Returns the singleton instance of the class.
     *
     * @return Loader
     */
    public static function getInstance()
    {
        if(empty(self::$_instance))
        {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Registers this instance as an autoloader.
     *
     * @return array
     */
    public function register()
    {
        spl_autoload_register(array($this,'loadClass'));
    }

    /**
     * Unregisters this instance as an autoloader.
     *
     * @return array
     */
    public function unregister()
    {
        spl_autoload_unregister(array($this, 'loadClass'));
    }

    /**
     * Register namescape path.
     *
     * @param $namespace
     * @param $rootDir
     * @return bool
     */
    public function addNamespacePath($namespace, $rootDir)
    {
        if (is_dir($rootDir))
        {
            $namespace = trim($namespace, '\\');
            $this->namespaces[$namespace] = $rootDir;
            return true;
        }

        return false;
    }

    /**
     * Returns the path for views.
     *
     * @param $root_namespace
     * @return string
     */
    public static function getPath($root_namespace)
    {
        if(!empty($root_namespace))
        {
            $root_namespace = trim($root_namespace, '\\');
            $root = __DIR__.'/../src/'.$root_namespace;
            return $root;
        }
    }

    /**
     * Loads the given class or interface.
     *
     * @param $class
     * @return bool
     */
    protected function loadClass($class)
    {
        try
        {
            $pathParts = explode('\\', $class);
            if(is_array($pathParts))
            {
                $namespace = array_shift($pathParts);
                if (!empty($this->namespaces[$namespace]))
                {
                    $filePath = $this->namespaces[$namespace] . '/' . implode('/', $pathParts) . '.php';
                    if(file_exists($filePath))
                    {
                        require_once $filePath;
                    } else
                    {
                        throw new ClassNotFoundException('File not found - '.$filePath);
                    }
                    return true;
                } else
                {
                    throw new NamespaceException('Namespace not found - '.$namespace);
                }
            }
            return false;
        } catch(ClassNotFoundException $e)
        {
            echo 'ERROR:'.$e->getMessage();
        }
        catch(NamescapesException $e)
        {
            echo 'ERROR:'.$e->getMessage();
        }
    }
}

$loader = Loader::getInstance();
$loader->register();
