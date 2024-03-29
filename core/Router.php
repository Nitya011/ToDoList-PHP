<?php

class Router {
    public $routes = [
        'GET' => [],
        'POST' => [],
        'PUT' => [], 
        'DELETE' => []
    ];

    public static function load($file) {
        $router = new static;
        require $file;
        return $router;
    }

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

    public function direct($uri, $requestType) {
        //var_dump($uri, $this->routes[$requestType]);
        if (array_key_exists($uri, $this->routes[$requestType])) {
            return $this->callAction(
                ...explode('@', $this->routes[$requestType][$uri])
            );
        }
        throw new Exception('No route defined for this URI.');
    }

    protected function callAction($controller, $action) {
        $controller = new $controller;
        if (!method_exists($controller, $action)) {
            throw new Exception(
                "{$controller} does not respond to the {$action} action."
            );
        }
        return $controller->$action();
        //return call_user_func_array([$controller, $action], $params);
    }
}