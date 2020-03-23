<?php
class API_Response{

    public $code;
    public $message;
    private $http = array(
        200 => 'OK',
        201 => 'Created',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        408 => 'Request Time-out',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Large',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Time-out',
        505 => 'HTTP Version Not Supported',
    );

    public function __construct($code, $message){
        $this -> setCode($code);
        $this -> setMessage($message);
        $this -> sendResponse();
        die();
    }

    private function setCode($code){
        $this->code = $code;
    }

    private function setMessage($message){
        $this->message = $message;
    }

    private function sendResponse(){
        header('HTTP/1.1 '.$this -> code.' '.$this -> http[ $this -> code ] );
        http_response_code( $this -> code );
        echo json_encode( $this -> message );
    }

}