<?php

class Router {
    private array $routes = [];

    public function get(string $uri, string $action) {
        $this->routes['GET'][$uri] = $action;
    }

    public function post(string $uri, string $action) {
        $this->routes['POST'][$uri] = $action;
    }

    public function dispatch(string $uri, string $method) {
        $path = parse_url($uri, PHP_URL_PATH);

        if (!isset($this->routes[$method][$path])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        [$controller, $methodName] = explode('@', $this->routes[$method][$path]);
        $controller = new $controller();
        $controller->$methodName();
    }
}
