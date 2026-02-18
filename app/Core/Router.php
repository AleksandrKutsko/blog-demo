<?php

namespace App\Core;

class Router
{
    /**
     * @var array[] Массив маршрутов. url => handler
     */
    private static $routes = [
        'get' => [],
        'post' => [],
        'put' => [],
        'patch' => [],
        'delete' => []
    ];

    /**
     * @var array[] Параметры из url
     */
    private static $params = [];

    /**
     * @param $name
     * @param $params
     * @return void
     */
    public static function __callStatic($name, $params) :void
    {
        if(isset(self::$routes[$name])){
            $url = (isset($params[0]) && str_contains($params[0], '/')) ? $params[0] : false;
            $handler = (isset($params[1]) && str_contains($params[1], '@')) ? $params[1] : false;

            if($url && $handler){
                self::$routes[$name][$url] = $handler;
            }
        }
    }

    /**
     * @return array[]
     */
    public static function getRouteList() :array
    {
        return self::$routes;
    }

    /**
     * @param $method
     * @param $uri
     * @return false|mixed
     */
    private static function searchRoute($method, $uri){
        if(isset(self::$routes[$method][$uri])){
            return self::$routes[$method][$uri];
        }

        foreach(self::$routes[$method] as $route => $handler){
            $pattern = self::compilePattern($route);

            if(preg_match($pattern, $uri, $matches)){
                array_shift($matches);

                foreach($matches as $k => $match){
                    if(is_numeric($k)) unset($matches[$k]);
                }

                self::$params = $matches;
                return $handler;
            }
        }

        return null;
    }

    private static function compilePattern($route){
        $pattern = str_replace('/', '\/', $route);

        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^\/]+)', $pattern);

        return '/^' . $pattern . '$/';
    }

    public static function dispatch(){
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $uri = $_SERVER['REQUEST_URI'];

        $handler = self::searchRoute($method, $uri) ?? self::searchRoute('get', '/404');

        self::handle($handler);
    }

    private static function handle($handler){
        list($controller, $method) = explode('@', $handler);

        $controllerClass = 'App\\Controllers\\' . $controller;

        if(!class_exists($controllerClass)){
            throw new \Exception("Ошибка построения маршрута");
        }

        $controller = new $controllerClass();

        if(!method_exists($controller, $method)){
            throw new \Exception("Ошибка отображения маршрута");
        }

        return call_user_func_array([$controller, $method], self::$params);
    }
}