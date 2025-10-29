<?php

namespace Traits;

/**
 * Trait HttpResponseTrait
 * 
 * Provides helper methods for handling HTTP redirects
 */
trait HttpResponseTrait
{
    /**
     * Redirect to the specified path
     * 
     * @param string $path
     * @return never
     */
    public function redirect(string $path) : void
    {
        header('Location: /' . PROJECT_NAME . $path);
        exit();
    }

    /**
     * Redirect to the previous path
     * 
     * @return never
     */
    public function back() : void
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}