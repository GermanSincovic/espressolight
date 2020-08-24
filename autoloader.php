<?php

spl_autoload_register(function($class) {
    $a = explode('\\', $class);
    $last = array_pop($a);
    $fn = $class . '.php';
    $fn = ROOT_DIR . str_replace('\\', '/', $fn);
    if (file_exists($fn)) require $fn;
});