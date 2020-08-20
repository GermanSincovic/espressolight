<?php

require_once("../model/Entities/User.php");
require_once("../model/Parser.php");

class DBObjectSaver{

    private $obj;
    private $objName;
    private $objPrimaryKey;
    private $objTable;

    public function __construct($obj){
        $this->obj           = $obj;
        $this->objName       = get_class($this->obj);
        $objProperties       = Parser::getAnnotationInfo($this->objName);
        $this->objPrimaryKey = $objProperties["primary_key"];
        $this->objTable      = $objProperties["table"];
    }
}

new DBObjectSaver(new User());