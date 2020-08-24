<?

require_once './vendor/autoload.php';

//use utils\ORM;

require 'config.php';
require 'autoloader.php';

(new controller\Router) -> callEndpoint();