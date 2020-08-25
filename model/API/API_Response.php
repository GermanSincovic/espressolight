<?php

namespace model\API;

use model\API\API as API;

class API_Response extends API{

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
        520 => 'Unknown Error'
    );

    public function __construct($code, $message = false, $debugMode = false){
        parent::__construct();
        $this -> setCode($code);
        $this -> setMessage( $message ? $message : [ 'message' => $this -> http[$code]] );
        $this -> sendResponse($debugMode);
        die();
    }

    private function setCode($code){
        $this->code = $code;
    }

    private function setMessage($message){
        $this->message = $message;
    }

    private function sendResponse($debugMode){
        header('HTTP/1.1 '.$this -> code.' '.$this -> http[ $this -> code ] );
        http_response_code( $this -> code );
        if($debugMode) {
            var_dump($this->message);
        } else {
            echo json_encode([ 'response_code' => $this -> code, 'message' => $this->message ]);
        }
    }

}