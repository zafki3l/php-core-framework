<?php

namespace Core;

/**
 * Class ErrorHandler
 * 
 * Provides helper methods for all ErrorHandler classes
 */
class ErrorHandler
{
    /**
     * Check is input empty
     * @param mixed $name
     * @return bool
     */
    public function emptyInput($name) : bool
    {
        return empty($name);
    }
}