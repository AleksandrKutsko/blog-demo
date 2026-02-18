<?php

namespace App\Core;

use Smarty\Smarty;

class SmartyWrapper
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = new Smarty();

        $this->smarty->setTemplateDir(__DIR__ . '/../../templates/');
        $this->smarty->setCompileDir(__DIR__ . '/../../templates_c/');

        $this->smarty->compile_check = true;
        $this->smarty->debugging = false;
        $this->smarty->caching = false;
    }

    public function render($template, $data = [])
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        return $this->smarty->fetch($template);
    }

    public function display($template, $data = [])
    {
        foreach ($data as $key => $value) {
            $this->smarty->assign($key, $value);
        }
        $this->smarty->display($template);
    }
}