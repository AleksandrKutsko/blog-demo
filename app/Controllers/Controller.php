<?php

namespace App\Controllers;
use App\Core\SmartyWrapper;

class Controller
{
    private object $smarty;

    public function __construct()
    {
        $this->smarty = new SmartyWrapper();
    }

    protected function smarty() :object
    {
        return $this->smarty;
    }
}