<?php

namespace App\Services;

use App\Interfaces\ViewInterface;

class View implements ViewInterface
{
    static public function include(string $component): void
    {
        $view = str_replace('.', DIRECTORY_SEPARATOR, $component);

        require_once Application::$view_dir . "{$view}.view.php";
    }

    public function renderView($view, array $data = []): string
    {
        $viewContent = $this->viewContent($view, $data);

        return $viewContent;
    }

    protected function viewContent(string $view, array $data): string
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        self::include($view);
        return ob_get_clean();
    }
}
