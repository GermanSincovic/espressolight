<?php

namespace utils\ORM;
use controller\Parser;
use Exception;
use model\API\API_Response;
use mysqli;
use mysqli_sql_exception;
use ReflectionClass;

class Butler{

    /**
     * @var mysqli
     */
    public static $connection;

    public static $crumb;

    public static $response;

    public static function connectDB($host, $user, $pass, $name){
        try{
            self::$connection = new mysqli($host, $user, $pass);

        } catch (Exception $e){
            die("DB connection failed!");
        }
        try{
            self::$connection -> select_db($name);
        } catch (mysqli_sql_exception $e){
            die("DB connection failed!");
        }
    }

    /**
     * @param $model object
     * @return object
    */
    public static function init($model){
        self::$crumb = new Crumb($model);
        return self::$crumb -> model;
    }

    public static function exec($query){
        try {
            self::$response = self::$connection->query($query);
        } catch (mysqli_sql_exception $e){
            new API_Response(520, [ 'message' => self::$connection->error]);
        }
        new API_Response(200, Parser::DBResponseToArray(self::$response));
    }

}