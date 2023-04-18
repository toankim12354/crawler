<?php

namespace Toanlt\Crawler\Controllers;

abstract class BaseController
{
    protected function view(string $path, array $data = []): void
    {
        $path = VIEW_PATH . '/' . trim($path, ' /');

        extract($data);

        ob_start();
        require $path;
        $content = ob_get_clean();

        echo $content;
    }

    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
    }
}