<?php

namespace Framework\Database;

/**
 * Class QueryConnect - Database connection PDO means.
 *
 * @package Framework\Database
 * @author JuraZubach
 * @since 1.0
 */
class QueryConnect
{
    static private $pdo;

    /**
     * The connection to the database, PDO means.
     *
     * @param $params
     */
    public function __construct($params)
    {
        $dsn = $params['dsn'];
        $user = $params['user'];
        $password = $params['password'];
        try
        {
            self::$pdo = new \PDO($dsn, $user, $password);
            register_shutdown_function([$this, 'closeConnection']);
        }
        catch (\PDOException $e)
        {
            die('SQL CONNECTION ERROR: '.$e->getMessage());
        }
    }

    /**
     * Returns the class property $pdo, in which the database connection.
     *
     * @return \PDO
     */
    static public function getDatabase()
    {
        return self::$pdo;
    }

    /**
     * Sets the property $pdo to Null.
     */
    static public function closeConnection()
    {
        self::$pdo = NULL;
    }
}