<?php
class API_Accounts extends API{

    public function getAccountList(){

        global $DB_connection;

        $query = new Query();
        $query->setAction('SELECT');
        $query->setTable('accounts');
        $query->setSelector(['accounts.*', 'users.user_full_name', 'users.user_email']);
        $query->setJoin('RIGHT JOIN users ON accounts.owner_id = users.user_id');

        $response = $DB_connection -> query($query->assembly());

        if($DB_connection -> errno){
            new API_Response(520, [ 'message' => $DB_connection -> error]);
        }

        new API_Response(200, Parser::DBResponseToArray($response) );
    }

    public function getAccount(){

    }

    public function createAccount(){

    }

    public function updateAccount(){

    }

    public function deleteAccount(){

    }

}