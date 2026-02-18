<?php

namespace App\Controllers;
use App\Core\SmartyWrapper;

class Controller
{
    private $smarty;

    public function __construct()
    {
        $this->smarty = new SmartyWrapper();
    }

    protected function smarty()
    {
        return $this->smarty;
    }
}