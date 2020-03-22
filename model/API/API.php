<?php
class API{

    public $method;
    public $endpoint;
    public $body;
    public $get;

    public function __construct(){

        global $Router;

        $this -> method = $_SERVER['REQUEST_METHOD'];
        $this -> endpoint = $Router -> urlPattern;
        $this -> body = $_POST ? $_POST : json_decode(file_get_contents('php://input'), TRUE);
        $this -> get = $Router -> varsGet;
    }
}