<?php

namespace App;

class Router
{
    public static array $routes = [];
    public static array $route = [];

    public static function addRoute($regex, $route = [])
    {
        self::$routes[$regex] = $route;
    }

    public static function dispatcher(): void
    {
        $query = urldecode($_SERVER['QUERY_STRING']);
        if (self::searchRoute($query)) {
            $controller = '\\App\Controllers\\' . self::$route['controller'] . 'Controller';
            if (class_exists($controller)) {
                $controllerObject = new $controller(self::$route);
                $action = 'action' . self::CamelCase(self::$route['action']);
                if (method_exists($controllerObject, $action)) {
                    echo $controllerObject->$action();
                } else {
                    throw new \Exception("Method {$controller}::{$action} not found.", 404);
                }
            } else {
                throw new \Exception("Controller {$controller} not found.", 404);
            }
        }
        else {
            throw new \Exception("Page not found.", 404);
        }
    }

    private static function searchRoute($url): bool
    {
        $url = explode('&', $url);
        foreach (self::$routes as $pattern => $route) {
            if (preg_match("#{$pattern}#", $url[0], $matches)) {
                foreach ($matches as $key => $value) {
                    if (is_string($key)) {
                        $route[$key] = $value;
                    }
                }
                if (empty($route['action'])) {
                    $route['action'] = 'Index';
                }
                $route['controller'] = self::CamelCase($route['controller']);
                self::$route = $route;
                return true;
            }
        }
        return false;
    }

    private static function CamelCase($name): string
    {
        return ucwords(mb_strtolower($name), "_");
    }
}