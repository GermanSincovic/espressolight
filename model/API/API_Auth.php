<?php
class API_Auth extends API{

    public function __construct($action){
        parent::__construct();
        switch ($action){
            case 'login' : $this -> login() ; break;
            case 'logout' : $this -> logout() ; break;
        }
    }

    private function login(){
        global $Parser;
        global $DB_connection;

//         $Parser -> DBResponseToArray(
         echo   $DB_connection -> query(
                "SELECT * FROM `users` WHERE "
                ."`user_login`='". $this -> body['login'] ."'"
                ."`user_password`='" . $Parser -> getPassHash($this -> body['password'])."'"
            );
//        );
    }

    private function logout(){
        session_start();
        session_destroy();
        global $DB;
        unset($DB);
    }

}