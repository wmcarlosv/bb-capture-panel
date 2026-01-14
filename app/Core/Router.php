<?php

namespace App\Core;

class Router {
    protected $routes = [];

    public function get($uri, $controller) {
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller) {
        $this->routes['POST'][$uri] = $controller;
    }

    public function put($uri, $controller) {
        $this->routes['PUT'][$uri] = $controller;
    }

    public function delete($uri, $controller) {
        $this->routes['DELETE'][$uri] = $controller;
    }

    public function dispatch($uri, $method) {
        $uri = parse_url($uri, PHP_URL_PATH);
        if ($uri !== '/' && substr($uri, -1) === '/') {
            $uri = rtrim($uri, '/');
        }

        // Check for exact match
        if (isset($this->routes[$method][$uri])) {
            $this->callAction($this->routes[$method][$uri]);
            return;
        }

        // Check for dynamic routes
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $action) {
                // Convert {id} to regex
                $pattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
                $pattern = "@^" . $pattern . "$@D";
                
                if (preg_match($pattern, $uri, $matches)) {
                    array_shift($matches); // remove full match
                    $this->callAction($action, $matches);
                    return;
                }
            }
        }

        // 404
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['error' => 'Route not found']);
    }

    protected function callAction($action, $params = []) {
        list($controller, $method) = explode('@', $action);
        
        // Check if it's an API controller or Web
        if (strpos($controller, 'Api') === 0) {
            $controller = "App\\Controllers\\Api\\{$controller}";
        } else {
            $controller = "App\\Controllers\\{$controller}";
        }

        if (class_exists($controller)) {
            $controllerInstance = new $controller();
            call_user_func_array([$controllerInstance, $method], $params);
        } else {
            echo "Controller class $controller not found";
        }
    }
}