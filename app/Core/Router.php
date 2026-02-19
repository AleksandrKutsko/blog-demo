<?php

namespace App\Core;

class Router
{
    /**
     * @var array[] Массив маршрутов. url => handler
     */
    private static array $routes = [
        'get' => [],
        'post' => [],
        'put' => [],
        'patch' => [],
        'delete' => []
    ];

    /**
     * @var array Наименования роутов. Для генерации
     */
    private static array $namedRoutes = [];

    /**
     * @var array[] Параметры из url
     */
    private static array $params = [];

    /**
     * Регистрация роутов в ядре
     * @param $name
     * @param $params
     * @return void
     */
    public static function __callStatic($name, $params) :void
    {
        if(isset(self::$routes[$name])){
            $url = (isset($params[0]) && str_contains($params[0], '/')) ? $params[0] : false;
            $handler = (isset($params[1]) && str_contains($params[1], '@')) ? $params[1] : false;
            $routeName = (isset($params[2])) ? $params[2] : false;

            if($url && $handler){
                self::$routes[$name][$url] = $handler;
            }

            if($url && $routeName){
                self::$namedRoutes[$routeName] = $url;
            }
        }
    }

    /**
     * Возвращает список роутов
     * @return array[]
     */
    public static function getRouteList() :array
    {
        return self::$routes;
    }

    /**
     * Поиск роута
     * @param $method
     * @param $uri
     * @return false|mixed
     */
    private static function searchRoute(string $method, string $uri) :string|null
    {
        //Поиск роута по полному совпадению
        if(isset(self::$routes[$method][$uri])){
            return self::$routes[$method][$uri];
        }

        //Поиск сложных роутов с данными в uri "{id}"
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

    /**
     * Компиляция роута в регулярку
     * @param $route
     * @return string
     */
    private static function compilePattern(string $route) :string
    {
        $pattern = str_replace('/', '\/', $route);

        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^\/]+)', $pattern);

        return '/^' . $pattern . '$/';
    }

    /**
     * Запуск маршрутизатора
     * @return void
     * @throws \Exception
     */
    public static function dispatch() :void
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];

        $handler = self::searchRoute($method, $uri) ?? self::searchRoute('get', '/404');

        self::handle($handler);
    }

    /**
     * Запуск обработчика роута
     * @param $handler
     * @return mixed
     * @throws \Exception
     */
    private static function handle(string $handler) :null
    {
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

    /**
     * Получить url по имени роута с нужными параметрами
     * @param string $name
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    public static function url(string $name, array $params = []) :string
    {
        if(!isset(self::$namedRoutes[$name])){
            throw new \Exception("Маршрут не найден");
        }

        $url = self::$namedRoutes[$name];

        foreach($params as $k => $v){
            $url = str_replace("{{$k}}", $v, $url);
        }

        return $url;
    }
}