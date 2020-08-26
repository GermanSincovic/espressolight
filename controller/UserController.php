<?php

namespace controller;

use model\API\API;
use model\API\API_Response;
use R;
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

    public function getUser($id){
        $result = R::findOne('users', 'id = '. $id);
        $result ? new API_Response(200, $result) : new API_Response(404);
    }

    public function createUser($data){
        $newUser = R::dispense('users');
//          REQUIRED FIELDS
        $newUser -> account_id = Parser::isValid('id', $data['account_id']);
        $newUser -> role_id = Parser::isValid('id', $data['role_id']);
        $newUser -> branch_id = Parser::isValid('id', $data['branch_id']);
        $newUser -> user_login = Parser::isValid('login', $data['user_login']);
        $newUser -> user_first_name = Parser::isValid('name', $data['user_first_name']);
        $newUser -> user_second_name = Parser::isValid('name', $data['user_second_name']);
        $newUser -> user_full_name = $newUser -> user_first_name . $newUser -> user_last_name;
        $newUser -> user_email = Parser::isValid('email', $data['user_email']);
        $newUser -> user_password = Parser::getPassHash(Parser::isValid('password', $data['user_password']));
        $newUser -> user_second_name = Parser::isValid('name', $data['user_second_name']);
//          EOF REQUIRED FIELDS
        if(isset($data['user_phone'])){ $newUser -> user_phone = Parser::isValid('phone', $data['user_phone']); }
        if(isset($data['user_comment'])){ $newUser -> user_comment = Parser::isValid('text', $data['user_comment']); }
        if(isset($data['user_active'])){ $newUser -> user_active = Parser::isValid('boolean', $data['user_phone']); }
        $newUser -> user_created_at = date('Y-m-d H:i:s');
        $newUser -> user_updated_at = $newUser -> user_created_at;
        try {
            $id = R::store($newUser);
            new API_Response(200, R::findOne('users', 'id = '.$id));
        } catch (SQL $e) {
            new API_Response(520, $e->getMessage());
        }
    }

    public function updateUser($id, $data){
        if(!Parser::isValid('id', $id) OR isset($data['id'])){ new API_Response(400); }
        $updatingUser = R::load('users', $id);
        if(isset($data['account_id'])){         $updatingUser -> account_id = Parser::isValid('id', $data['account_id']); }
        if(isset($data['role_id'])){            $updatingUser -> role_id = Parser::isValid('id', $data['role_id']); }
        if(isset($data['branch_id'])){          $updatingUser -> branch_id = Parser::isValid('id', $data['branch_id']);}
        if(isset($data['user_login'])){         $updatingUser -> user_login = Parser::isValid('login', $data['user_login']);}
        if(isset($data['user_first_name'])){    $updatingUser -> user_first_name = Parser::isValid('name', $data['user_first_name']);}
        if(isset($data['user_second_name'])){   $updatingUser -> user_second_name = Parser::isValid('name', $data['user_second_name']);}
        if(isset($data['user_full_name'])){     $updatingUser -> user_full_name = $updatingUser -> user_first_name . $updatingUser -> user_last_name;}
        if(isset($data['user_email'])){         $updatingUser -> user_email = Parser::isValid('email', $data['user_email']);}
        if(isset($data['user_password'])){      $updatingUser -> user_password = Parser::getPassHash(Parser::isValid('password', $data['user_password']));}
        if(isset($data['user_second_name'])){   $updatingUser -> user_second_name = Parser::isValid('name', $data['user_second_name']);}
        if(isset($data['user_phone'])){         $updatingUser -> user_phone = Parser::isValid('phone', $data['user_phone']); }
        if(isset($data['user_comment'])){       $updatingUser -> user_comment = Parser::isValid('text', $data['user_comment']); }
        if(isset($data['user_active'])){        $updatingUser -> user_active = Parser::isValid('boolean', $data['user_active']); }
        $updatingUser -> user_updated_at = date('Y-m-d H:i:s');
        $id = R::store($updatingUser);
        new API_Response(200, R::findOne('users', 'id = '. $id));
    }

    public function deleteUser($id){
        $result = R::findOne('users', 'id = '. $id);
        if($result->count() == 0) {
            new API_Response(404);
        }
        R::trash($result);
        if(!R::findOne('users', 'id = '. $id)){
            new API_Response(200, 'User('.$id.') deleted', true);
        }
    }

}