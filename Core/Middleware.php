<?php

namespace Core;

class Middleware
{
    public static function ensureAuth() : bool
    {
        return isset($_SESSION['user']) ? true : false;
    }
}