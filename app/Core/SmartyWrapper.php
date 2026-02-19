<?php

namespace App\Core;

use Smarty\Smarty;

class SmartyWrapper
{
    private object $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();

        $this->smarty->setTemplateDir(__DIR__ . '/../../templates/');
        $this->smarty->setCompileDir(__DIR__ . '/../../templates_c/');

        $this->smarty->compile_check = true;
        $this->smarty->debugging = false;
        $this->smarty->caching = false;

        $this->registerRouteFunction();
    }

    public function render($template, $data = []) :string
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        return $this->smarty->fetch($template);
    }

    public function display($template, $data = []) :void
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->display($template);
    }

    /**
     * Регистрация функции route для генерации url в шаблонах
     * @return void
     * @throws \Smarty\Exception
     */
    private function registerRouteFunction()
    {
        $this->smarty->registerPlugin('function', 'route', function($params){
            $name = $params['name'] ?? null;
            $routeParams = $params['params'] ?? [];

            // Если параметры переданы строкой вида "id=1,slug=test"
            if (is_string($routeParams)) {
                parse_str(str_replace(',', '&', $routeParams), $routeParams);
            }

            // Удаляем служебные параметры Smarty
            unset($params['name'], $params['params']);

            $routeParams = array_merge($routeParams, $params);

            try{
                return Router::url($name, $routeParams);
            } catch (\Exception $e){
                return '#';
            }
        });
    }
}