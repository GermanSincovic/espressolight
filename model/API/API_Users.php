<?php
class API_Users extends API{

    public function getUserList(){

        global $DB_connection;

        $account = $_SESSION['auth']['account_id'];
        $branch = $_SESSION['auth']['branch_id'];

        $query = "SELECT * FROM `users` ";
        if( $account OR $branch ) { $query.= "WHERE ";}
        if( $account ) { $query.= "`account_id`=".$account; }
        if( $branch ) { $query.= "`branch_id`=".$branch; }

        $response = $DB_connection -> query($query);
        new API_Response(200, [ 'users' =>  Parser::DBResponseToArray($response) ] );
    }

}