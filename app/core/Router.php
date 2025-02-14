<?php

class Router
{
    private $routes = [];

    public function add($method, $route, $controller, $action)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'route' => $route,
            'controller' => $controller,
            'action' => $action
        ];
    }

    public function matchRoutes($url, $method)
    {
        foreach ($this->routes as $routeData) {
            $routePattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<\1>[a-zA-Z0-9_-]+)', $routeData['route']);
            $routePattern = str_replace('/', '\/', $routePattern);
            $routePattern = '/^' . $routePattern . '$/';

            if (preg_match($routePattern, $url, $matches) && $routeData['method'] === $method) {
                return [
                    'controller' => $routeData['controller'],
                    'action' => $routeData['action'],
                    'params' => array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY)
                ];
            }
        }
        return false;
    }
}
?>