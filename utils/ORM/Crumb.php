<?php

namespace utils\ORM;

use ReflectionClass;
use ReflectionException;

class Crumb{

    public $model;
    public $primary_key;
    public $table;

    public function __construct($model){
        $this -> model =  $model;
        $this -> model -> role_id = 123;
        $this -> getAnnotationInfo(get_class($model));
        return $this;
    }

    public function getAnnotationInfo($className){
        try {
            $annotation = (new ReflectionClass($className))->getDocComment();
        } catch (ReflectionException $e) {
            die("No annotation found! " . $e);
        }
        $data = preg_replace('/[\/\s\*]/', "", $annotation);
        $data = preg_split("/@/", $data, 0, PREG_SPLIT_NO_EMPTY);
        foreach ($data as $v) {
            $tmp = explode("=", $v);
            $res[$tmp[0]] = $tmp[1];
        }
        if(!$res){ return false; }
        $this -> primary_key = $res["primary_key"];
        $this -> table = $res["table"];
    }

}