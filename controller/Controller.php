<?php

namespace controller;

use RedBeanPHP\R as R;

class Controller{
    public function __construct(){
        R::setup( 'mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER, DB_PASS);
    }
}