<?php

namespace Toanlt\Crawler\Controllers;

abstract class BaseController
{
    /**
     * @param string $path
     * @param array $data
     * @return void
     */
    protected function view(string $path, array $data = []): void
    {
        $path = VIEW_PATH . '/' . trim($path, ' /');

        extract($data);

        ob_start();
        require $path;
        $content = ob_get_clean();

        echo $content;
    }

    /**
     * @param string $url
     * @return void
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . $url);
    }
}