<?php

namespace Core;

class ErrorHandler
{
    public function emptyInput($name) : bool
    {
        return empty($name);
    }
}