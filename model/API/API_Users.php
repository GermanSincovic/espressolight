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

        global $DB_connection;

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
        new API_Response(200, Parser::trimPassword(Parser::DBResponseToArray($response)));
    }

    public function createUser(){

        if(API_Auth::hasWriteAccessTo('users')){
            new API_Response(403);
        }

        global $DB_connection;

        Parser::isValid('login', $this->body['user_login']);
        Parser::isValid('password', $this->body['user_password']);
        Parser::isValid('email', $this->body['user_email']);
        Parser::isValid('id', $this->body['account_id']);
        Parser::isValid('id', $this->body['role_id']);
        Parser::isValid('id', $this->body['branch_id']);
        Parser::isValid('name', $this->body['user_first_name']);
        Parser::isValid('name', $this->body['user_second_name']);


        $query = new Query();
        $query -> setAction('INSERT');
        $query -> setTable('users');
        $query -> setParams([

            // REFACTORING BY USER PRIVILEGES (MASTER OWNER)

            'user_login' => $this->body['user_login'],
            'user_password' => $this->body['user_password'],
            'user_email' => $this->body['user_email'],
            'account_id' => $this->body['account_id'],
            'role_id' => $this->body['role_id'],
            'branch_id' => $this->body['branch_id'],
            'user_first_name' => $this->body['user_first_name'],
            'user_second_name' => $this->body['user_second_name'],
        ]);

    }

    public function updateUser(){

    }

    public function deleteUser(){

    }



}