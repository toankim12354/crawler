<?php

namespace Toanlt\Crawler;

class Router
{
    public const REQUEST_METHOD_GET = 'get';
    public const REQUEST_METHOD_POST = 'post';
    private array $routes = [];

    public function addRoute(string $method, string $path, callable|array $callback): void
    {
        // Check if the path contains a parameter
        $path = trim($path);
        $path = preg_replace("/\//", "\\\/", $path);
        $path = preg_replace("/\{([\w]+)\}/", "(?P<$1>[^\/]+)", $path);
        $path = preg_replace("/\{([\w]+):([^\}]+)\}/", "(?P<$1>$2)", $path);
        $path = "/^" . $path . "$/i";

        $this->routes[$method][$path] = $callback;
    }

    //magic function
    public function __call(string $method, array $arguments)
    {
        $path = array_shift($arguments);
        $callback = array_shift($arguments);
        $this->addRoute($method, $path, $callback);
    }

    public function handleRequest(string $method, string $path): void
    {
        $method = strtolower(trim($method));
        $path = rtrim($path, '/');

        if (array_key_exists($method, $this->routes)) {
            foreach ($this->routes[$method] as $route => $callback) {
                $route = rtrim($route, '/');
                // Check if the route matches the path
                if (preg_match($route, $path, $matches)) {
                    // Remove the first match, which is the full path
                    array_shift($matches);
                    $params = array_unique($matches);
                    // Call the callback function with the matches as parameters
                    call_user_func_array($callback, $params);
                    return;
                }
            }
        }
        include __DIR__ . '/../views/errors/404.php';
    }

    public function dispatch(): void
    {
        $method = $this->getMethod();
        $url = $this->getUrl();

        $this->handleRequest($method, $url);
    }

    private function getUrl(): string
    {
        return rtrim($_SERVER['REQUEST_URI'] ?? '/', '/');
    }

    private function getMethod(): string
    {
        return strtolower($_SERVER['REQUEST_METHOD']);
    }
}
