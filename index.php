<?

require 'config.php';
require 'rb.php';
require 'autoloader.php';

(new controller\Router) -> callEndpoint();