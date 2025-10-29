<?php

namespace Core;

/**
 * Class Middlewares
 * 
 * provides helper methods for all Middleware Classes
 */
class Middleware
{
    /**
     * Ensure user is authenticated
     * @return bool
     */
    public static function ensureAuth() : bool
    {
        return isset($_SESSION['user']) ? true : false;
    }
}