<?php

namespace App\Services;

use App\Interfaces\ViewInterface;

class View implements ViewInterface
{
    static public function include(string $component): void
    {
        $view = str_replace('.', DIRECTORY_SEPARATOR, $component);

        include Application::$view_dir . "{$view}.view.php";
    }

    public function renderView($view, array $data = []): string
    {
        $viewContent = $this->viewContent($view, $data);

        return $viewContent;
    }

    protected function viewContent(string $view, array $data): string
    {
        $view = str_replace('.', DIRECTORY_SEPARATOR, $view);

        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include Application::$view_dir . "{$view}.view.php";
        return ob_get_clean();
    }
}
