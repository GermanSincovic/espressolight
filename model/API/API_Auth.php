<?php
class API_Auth extends API{

    public function __construct(){
        parent::__construct();

    }

    public function login(){

        if($this -> method != 'POST'){
            new API_Response(405, [ 'message' => 'Used method: '.$this -> method] );
        }

        if($this -> isLoggedIn()){
            new API_Response(200, [ 'message' => 'Already logged in'] );
        }

        global $DB_connection;

        $response = $DB_connection -> query("SELECT * FROM `users` WHERE `user_login`='". $this -> body['login'] ."' AND `user_password`='" . Parser::getPassHash($this -> body['password'])."'");
//        print_r($response);
        if(!$response -> errors) {
            if ($response->num_rows == 1) {
                $user_data = Parser::DBResponseToArraySingle($response);
                unset($user_data['user_password']);
                $_SESSION['auth'] = $user_data;
                new API_Response(200, [ 'message' => 'Logged in successfully'] );
            }
        }

    }

    public static function isLoggedIn(){
        return $_SESSION['auth']['user_id'] ? true : false ;
    }

    public static function logout(){
        session_start();
        session_destroy();
        global $DB;
        unset($DB);
        new API_Response(200, [ 'message' => 'Logged out successfully'] );
    }

}