<?php
class API_Users extends API{

    public function getUserList(){

        global $DB_connection;

        $account = $_SESSION['auth']['account_id'];
        $branch = $_SESSION['auth']['branch_id'];
        $response = $DB_connection -> query("SELECT * FROM `users` ");
        Parser::DBResponseToArraySingle($response);
        new API_Response(200, [ 'users' => $_SESSION['auth'] ] );
    }

}