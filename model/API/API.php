<?php

namespace model\API;

use controller\Router;

class API{

    public static $method;
    public static $body;
    public static $get;

    public function __construct(){

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        self::$method = $_SERVER['REQUEST_METHOD'];
        self::$body = $_POST ? $_POST : json_decode(file_get_contents('php://input'), TRUE);
        self::$get = (new Router) -> varsGet;

    }
}