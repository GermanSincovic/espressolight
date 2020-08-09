<?php
class API_Auth extends API{

    public function login(){

        global $DB_connection;

        if($this -> isLoggedIn()){
            new API_Response(200, [ 'message' => 'Already logged in'] );
        }

        $response = $DB_connection -> query("SELECT * FROM `users` WHERE `user_login`='". $this -> body['login'] ."' AND `user_password`='" . Parser::getPassHash($this -> body['password'])."'");

        // REFACTORING REQUIRED
        if($DB_connection -> errno == 0) {
            if ($response -> num_rows == 1) {
                $_SESSION['auth'] = Parser::noPassword(Parser::DBResponseToArraySingle($response));
                new API_Response(200, [ 'user' => $_SESSION['auth'] ] );
            } else {
                new API_Response(403);
            }
        } else {
            new API_Response(400);
        }

    }

    public static function getProp($prop){
        return $_SESSION['auth'][$prop];
    }

    public static function getLoggedInUserData(){
        new API_Response(200, [ 'user' => $_SESSION['auth'] ] );
    }

    public static function isLoggedIn(){
        return $_SESSION['auth']['user_id'] ? true : false ;
    }

    public static function isMaster(){
        return $_SESSION['auth']['role_id'] == 1 ? true : false ;
    }

    public static function isOwner(){
        return $_SESSION['auth']['role_id'] == 2 ? true : false ;
    }

    public static function isEmployee(){
        return (!API_Auth::isMaster() AND !API_Auth::isOwner());
    }

    public function logout(){
        session_start();
        session_destroy();
        global $DB;
        unset($DB);
        new API_Response(200, [ 'message' => 'Logged out successfully'] );
    }

}