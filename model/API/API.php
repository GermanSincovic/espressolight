<?php

namespace model\API;

use controller\Router;

class API{

    public $method;
    public $body;
    public $get;

    public function __construct(){

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        $this -> method = $_SERVER['REQUEST_METHOD'];
        $this -> body = $_POST ? $_POST : json_decode(file_get_contents('php://input'), TRUE);
        $this -> get = (new Router) -> varsGet;

    }
}