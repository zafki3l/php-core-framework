<?php

namespace Core;

abstract class Controller
{	
    private function renderView(string $view, array $data = []): void
    {
        require_once VIEW_PATH . $view . '.php';
    }

    protected function view(string $view, string $layout_view, string $title, array $data = [])
    {
        ob_start();
        $this->renderView($view, $data);

        $view_data = [
            'title' => $title,
            'content' => ob_get_clean(),
        ];

        $this->renderView($layout_view, $view_data);
    }
}
