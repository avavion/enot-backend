<?php

namespace App\Services;

class View
{
    public function renderView($view, array $data = []): string
    {
        $viewContent = $this->viewContent($view, $data);
        $layoutName = $this->getLayoutNameFromViewContent($viewContent);

        if (!$layoutName) {
            return $viewContent;
        }

        $layoutContent = $this->layoutContent($layoutName);
        return str_replace("{{ content }}", $viewContent, $layoutContent);
    }

    protected function viewContent(string $view, array $data): string
    {
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$root_dir . "/Views/{$view}.view.php";
        return ob_get_clean();
    }

    protected function getLayoutNameFromViewContent(string &$content): string|null
    {
        $regex = "/^@layout\('(?P<layout>.+)'\)/";
        preg_match($regex, $content, $matches);

        if (!array_key_exists("layout", $matches)) {
            return null;
        }

        $content = preg_replace($regex, "", $content); // TODO: Normal replacement for @pattern

        return $matches["layout"];
    }

    protected function layoutContent(string $layout): string
    {
        ob_start();
        include_once Application::$root_dir . "/Views/layouts/{$layout}.view.php";
        return ob_get_clean();
    }
}