<?php

namespace Core;

/**
 * Class Controller
 * 
 * BaseController provides helper methods for All Controller classes
 */
abstract class Controller
{	
    /**
     * Render a specified view 
     * @param string $view
     * @param array $data
     * @return void
     */
    private function renderView(string $view, array $data = []): void
    {
        require_once VIEW_PATH . $view . '.php';
    }

    /**
     * Render a view with a layout
     * 
     * @param string $view
     * @param string $layout_view
     * @param string $title
     * @param array $data
     * @return void
     */
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
