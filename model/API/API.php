<?php
class API{

    private $method;
    private $endpoint;
    private $body;


    private function registerEndpoint($endpoint, $method, $function){
        $this -> endpoint_map[$endpoint][$method] = $function;
    }

}