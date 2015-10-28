<?php

namespace Framework\Security\Model;

/**
 * Interface class User.
 *
 * @package Framework\Security\Model
 * @author JuraZubach
 * @since 1.0
 */
interface UserInterface
{
    /**
     * Gets users role.
     *
     * @return mixed
     */
    public function getRole();

    /**
     * Gets table name.
     *
     * @return mixed
     */
    public static function getTable();
}