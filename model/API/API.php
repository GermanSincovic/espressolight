<?php
class API{

    public $method;
    public $body;
    public $get;

    public function __construct(){

        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        global $Router;

        $this -> method = $_SERVER['REQUEST_METHOD'];
        $this -> body = $_POST ? $_POST : json_decode(file_get_contents('php://input'), TRUE);
        $this -> get = $Router -> varsGet;

    }
}