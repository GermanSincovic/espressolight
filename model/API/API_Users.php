<?php
class API_Users extends API{

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
        new API_Response(200, Parser::noPassword(Parser::DBResponseToArray($response)));
    }

    public function getUser(){

        global $DB_connection, $Router;

        $query = new Query();
        $query -> setAction('SELECT');
        $query -> setSelector(['users.*', 'roles.role_name']);
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
        $where['users.user_id'] = (new Router) -> varsPath[3];

        $query -> setWhere($where);

        $response = $DB_connection -> query($query -> assembly());
        if($DB_connection -> errno){
            new API_Response(520, [ 'message' => $DB_connection -> error]);
        }
        new API_Response(200, Parser::noPassword(Parser::DBResponseToArray($response)));
    }

    public function createUser(){

    }

    public function updateUser(){

    }

    public function deleteUser(){

    }



}