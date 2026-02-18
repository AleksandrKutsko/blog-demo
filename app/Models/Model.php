<?php

namespace App\Models;

use App\Config\Database;

class Model
{
    private $db;

    /*protected $table;

    protected $attributes;*/

    public function __construct(){
        $this->db = Database::getInstance();
    }

    protected function db(){
        return $this->db;
    }

    /*public function __get($name){

    }*/
}