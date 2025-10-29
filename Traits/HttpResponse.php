<?php

namespace Traits;

trait HttpResponseTrait
{
    // Redirect to the specified path
    public function redirect(string $path) : void
    {
        header('Location: /' . PROJECT_NAME . $path);
        exit();
    }

    // Redirect to the previous path
    public function back() : void
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}