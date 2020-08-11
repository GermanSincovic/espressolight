<?php
class API_Auth extends API{

    public function login(){

        global $DB_connection;

        if($this -> isLoggedIn()){
            new API_Response(200, [ 'message' => 'Already logged in'] );
        }

        $query = new Query();
        $query -> setAction("SELECT");
        $query -> setSelector(['users.*','roles.role_name','access_rules.*']);
        $query -> setTable('users');
        $query -> setJoin('INNER JOIN roles ON roles.role_id = users.role_id INNER JOIN access_rules ON access_rules.access_rule_id = roles.access_rule_id');
        $query -> setWhere(['users.user_login' => $this -> body['login'], 'users.user_password' => Parser::getPassHash($this -> body['password'])]);

        $response = $DB_connection -> query($query -> assembly());

        // REFACTORING REQUIRED
        if($DB_connection -> errno == 0) {
            if ($response -> num_rows == 1) {
                $_SESSION['auth'] = Parser::trimPassword(Parser::DBResponseToArraySingle($response));
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

    public static function hasReadAccessTo($table){
        return $_SESSION["auth"]["access_rule_$table"][0] == "r";
    }

    public static function hasWriteAccessTo($table){
        return $_SESSION["auth"]["access_rule_$table"] == "rw";
    }

    public function logout(){
        session_start();
        session_destroy();
        global $DB;
        unset($DB);
        new API_Response(200, [ 'message' => 'Logged out successfully'] );
    }

}