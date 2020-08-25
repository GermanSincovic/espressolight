<?

define("DOMAIN", "http://".$_SERVER['HTTP_HOST']."/");

define("DB_HOST", $_SERVER['HTTP_HOST']);

define("DB_NAME", "espressolight");

define("DB_USER", "admin");

define("DB_PASS", "admin");

define("SALT", "cf0665bea84");

//define('CONTROLLER_DIR', __DIR__ . '/controller/');

//define('MODEL_DIR', __DIR__ . '/model/');

define('ROOT_DIR', __DIR__ . '/');

define('PATTERN_ID', "/^\d+$/");

define('PATTERN_LOGIN', "/^[A-Za-z_0-9-]{6,20}$/");

define('PATTERN_PASSWORD', "/^[A-Za-z_0-9-]{8,32}$/");

define('PATTERN_NAME', "/^[A-Za-zА-Яа-я ']{2,}$/");

define('PATTERN_PHONE', "/^\d{12}$/");

define('PATTERN_BOOLEAN', "/^[01]{1}$/");