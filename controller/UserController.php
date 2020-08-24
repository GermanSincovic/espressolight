<?php

namespace controller;

use model\API\API;
use model\API\API_Response;
use RedBeanPHP\R as R;
use RedBeanPHP\RedException\SQL;

class UserController extends Controller {

    public function __construct(){
        parent::__construct();
        R::freeze(true);
    }

    public function getUserList(){
        $result = R::findAll('users');
        new API_Response(200,$result);
    }

    public function getUser(){
        $result = R::find('users', 'id = '.(new Router) -> varsPath[3]);
        $result ? new API_Response(200, $result) : new API_Response(404);
    }

    public function createUser(){
        $newUser = R::dispense('users');
        $newUser -> account_id = API::$body['account_id'];
        $newUser -> role_id = API::$body['role_id'];
        $newUser -> branch_id = API::$body['branch_id'];
        $newUser -> user_login = API::$body['user_login'];
        $newUser -> user_first_name = API::$body['user_first_name'];
        $newUser -> user_second_name = API::$body['user_second_name'];
//        $newUser -> user_full_name = $newUser -> user_first_name . $newUser -> user_last_name;
        $newUser -> user_email = API::$body['user_email'];
        $newUser -> user_password = API::$body['user_password'];
        try {
            $id = R::store($newUser);
            new API_Response(200, R::find('users', 'id = '.$id));
        } catch (SQL $e) {
            new API_Response(520, ['message' => $e], true);
//            Parser::debug($e);
        }
    }
}