<?php
class API_Users extends API{

    public function __construct(){

        parent::__construct();
        if(!API_Auth::isLoggedIn()){
            new API_Response(403);
        }
    }

    public function getUserList(){

        global $DB_connection;

        $query = new Query();
        $query -> setAction('SELECT');
        $query -> setSelector(['users.*','roles.role_name']);
        $query -> setTable('users');
        $query -> setJoin('INNER JOIN roles ON roles.role_id = users.role_id');

        $where = [];
        if(API_Auth::isOwner()){
            $where['users.account_id'] = API_Auth::getProp('account_id');
        }
        if(API_Auth::isEmployee()){
            $where['users.account_id'] = API_Auth::getProp('account_id');
            $where['users.branch_id'] = API_Auth::getProp('branch_id');
        }

        $query -> setWhere($where);
        $response = $DB_connection -> query($query -> assembly());
        if($DB_connection -> errno){
            new API_Response(520, [ 'message' => $DB_connection -> error]);
        }
        new API_Response(200, Parser::trimPassword(Parser::DBResponseToArray($response)));
    }

    public function getUser(){

        if(API_Auth::isOwner()){
            $where['users.account_id'] = API_Auth::getProp('account_id');
        }
        if(API_Auth::isEmployee()){
            $where['users.account_id'] = API_Auth::getProp('account_id');
            $where['users.branch_id'] = API_Auth::getProp('branch_id');
        }
        $where['users.user_id'] = (new Router) -> varsPath[3];

        global $DB_connection;

        $query = new Query();
        $query -> setAction('SELECT');
        $query -> setSelector(['users.*', 'roles.role_name']);
        $query -> setTable('users');
        $query -> setJoin('INNER JOIN roles ON roles.role_id = users.role_id');
        $query -> setWhere($where);
        $response = $DB_connection -> query($query -> assembly());

        if($DB_connection -> errno){
            new API_Response(520, [ 'message' => $DB_connection -> error]);
        }
        new API_Response(200, Parser::trimPassword(Parser::DBResponseToArray($response)));
    }

    public function createUser(){

        if(!API_Auth::hasWriteAccessTo('users')){
            new API_Response(403);
        }

        Parser::isValid('login', $this->body['user_login']);
        Parser::isValid('password', $this->body['user_password']);
        Parser::isValid('email', $this->body['user_email']);
        Parser::isValid('id', $this->body['account_id']);
        Parser::isValid('id', $this->body['role_id']);
        Parser::isValid('id', $this->body['branch_id']);
        Parser::isValid('name', $this->body['user_first_name']);
        Parser::isValid('name', $this->body['user_second_name']);

        $params['user_login'] = $this->body['user_login'];
        $params['user_password'] = Parser::getPassHash($this->body['user_password']);
        $params['user_email'] = $this->body['user_email'];
        $params['account_id'] = API_Auth::isMaster() ? $this->body['account_id'] : API_Auth::getProp('account_id');
        $params['role_id'] = ($this->body['role_id'] != "1") ? $this->body['role_id'] : new API_Response(403);
        $params['branch_id'] = $this->body['branch_id'];
        $params['user_first_name'] = $this->body['user_first_name'];
        $params['user_second_name'] = $this->body['user_second_name'];
        $params['user_full_name'] = $this->body['user_first_name']." ".$this->body['user_second_name'];

        global $DB_connection;

        $query = new Query();
        $query -> setAction('INSERT');
        $query -> setTable('users');
        $query -> setParams($params);
        $DB_connection -> query($query -> assembly());
        if($DB_connection -> errno){
            new API_Response(520, [ 'message' => $DB_connection -> error]);
        } else {
            new API_Response(200, [ 'message' => "Insertion ID ".$DB_connection -> insert_id]);
        }
    //test
    }

    public function updateUser(){

        if(!API_Auth::hasWriteAccessTo('users')){
            new API_Response(403);
        }

        global $DB_connection;

        if(isset($this->body['role_id'])){
            Parser::isValid('id', $this->body['role_id']);
            $params['role_id'] = ($this->body['role_id'] != "1") ? $this->body['role_id'] : new API_Response(403);
        }
        if(isset($this->body['branch_id'])){
            Parser::isValid('id', $this->body['branch_id']);
            $params['branch_id'] = $this->body['branch_id'];
        }
        if(isset($this->body['user_password'])){
            Parser::isValid('password', $this->body['user_password']);
            $params['user_password'] = Parser::getPassHash($this->body['user_password']);
        }
        if(isset($this->body['user_first_name']) && isset($this->body['user_second_name'])){
            Parser::isValid('name', $this->body['user_first_name']);
            Parser::isValid('name', $this->body['user_second_name']);
            $params['user_first_name'] = $this->body['user_first_name'];
            $params['user_second_name'] = $this->body['user_second_name'];
            $params['user_full_name'] = $this->body['user_first_name']." ".$this->body['user_second_name'];
        }
        if(isset($this->body['user_email'])){
            Parser::isValid('email', $this->body['user_email']);
            $params['user_email'] = $this->body['user_email'];
        }
        if(isset($this->body['user_email'])){
            Parser::isValid('email', $this->body['user_email']);
            $params['user_email'] = $this->body['user_email'];
        }
        if(isset($this->body['user_phone'])){
            Parser::isValid('phone', $this->body['user_phone']);
            $params['user_phone'] = $this->body['user_phone'];
        }
        if(isset($this->body['user_comment'])){
            Parser::isValid('text', $this->body['user_comment']);
            $params['user_comment'] = $this->body['user_comment'];
        }
        if(isset($this->body['user_active'])){
            if($this->body['user_active'] == "1" OR $this->body['user_active'] == "0"){
                $params['user_active'] = $this->body['user_active'];
            }
        }

        if(empty($params)){ new API_Response(400, ["message" => "No parameters are provided"]); }

        $where['users.user_id'] = (new Router) -> varsPath[3];

        $query = new Query();
        $query -> setAction("UPDATE");
        $query -> setTable("users");
        $query -> setParams($params);
        $query -> setWhere($where);
        $DB_connection -> query($query -> assembly());
        if($DB_connection -> errno){
            new API_Response(520, [ 'message' => $DB_connection -> error]);
        } else {
            new API_Response(200);
        }
    }

    public function deleteUser(){

        if(!API_Auth::hasWriteAccessTo('users')){
            new API_Response(403);
        }

        global $DB_connection;

        $where['users.user_id'] = (new Router) -> varsPath[3] != "1"? (new Router) -> varsPath[3] : new API_Response(403);;

        $query = new Query();
        $query -> setAction("DELETE");
        $query -> setSelector('*');
        $query -> setTable("users");
        $query -> setWhere($where);
        Parser::debug($query -> assembly());
        $DB_connection -> query($query -> assembly());
        if($DB_connection -> errno){
            new API_Response(520, [ 'message' => $DB_connection -> error]);
        } else {
            new API_Response(200);
        }
    }
}