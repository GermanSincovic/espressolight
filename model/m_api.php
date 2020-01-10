<?
class API{

	private $method;
	private $endpoint;
	private $request_body;

	private $query;
	public $response;

	private $endpoint_map = [
		"/api/auth/login" => [
			"POST" => "login"
		],
		"/api/auth/logout" => [
			"POST" => "logout"
		],
		"/api/users" => [
			"GET" => "getUserList"
		],
		"/api/users/{id}" => [
			"GET" => "getUser",
			"PUT" => "createUser",
			"POST" => "updateUser",
			"DELETE" => "deleteUser"
		]
	];

	public function sendRequest(){
		global $DB;
		$this -> response = $DB -> query($this -> query);
		if ($DB -> errno) {
			$this -> message(400);
		}
	}

	public function getResponse(){
		global $DB;
		switch ($this -> method) {
			case 'GET': 
				$tmparr = array();
				while ($row = $this -> response -> fetch_assoc()) {
					$tmparr[$row["id"]] = $row;
				}
				$this -> response = $tmparr;
				if( $_POST['password'] ){ 
					return $this -> response; 
				} else {
					echo json_encode($this -> response);
				}
				break;
			case 'POST': $this -> message(200); break;
			case 'PUT': $this -> message(201); break;
			case 'DELETE': $this -> message(200); break;
		}
	}

	public function prepareRequest($method, $component, $subcomponent, $body){

		$q = "";

		// forming ACTION according to METHOD
		switch ($method) {
			case 'GET': $q = "SELECT * FROM "; break;
			case 'POST': $q = "UPDATE "; break; 
			case 'PUT': $q = "INSERT INTO "; break;
			case 'DELETE': $q = "DELETE FROM "; break;
			default: $this -> message(405); break;
		}

		// forming TABLE according COMPONENT
		if($component){
			$q .= "`".$component."`";
		} else {
			$this -> message(400);
		}

		// forming WHERE / SET+WHERE according REQUEST_BODY and SUBCOMPONENT
		switch ($method) {
			case 'GET':
				if ($body && !$subcomponent){ $q .= " WHERE" . $this -> parseRequestBody($body, 'AND'); }
				elseif (!$body && $subcomponent) { $q .= " WHERE `id`='" . $subcomponent . "'"; }
				elseif (!$body && !$subcomponent) { $q .= ""; }
				else { $this -> message(400); }	
				break;
			case 'POST': 
				if ($body && $subcomponent && !$body['id']) { 
					$q .= " SET" . $this -> parseRequestBody($body, ',') . " WHERE `id`='" . $subcomponent . "'"; 
				} else { $this -> message(400); }
				break; 
			case 'PUT': 
				if ($body && !$subcomponent && !$body['id']){
					$q .= " SET " . $this -> parseRequestBody($body, ','); 
				} else { $this -> message(400); }
				break;
			case 'DELETE': 
				if ($body && !$subcomponent){ $q .= " WHERE" . $this -> parseRequestBody($body, 'AND'); }
				elseif (!$body && $subcomponent){ $q .= " WHERE `id`='" . $subcomponent . "'"; }
				else { $this -> message(400); }
				break;
		}


		$this -> query = $q;
	}

	private function message($num){
		$http = array(
	        100 => 'Continue',
	        101 => 'Switching Protocols',
	        200 => 'OK',
	        201 => 'Created',
	        202 => 'Accepted',
	        203 => 'Non-Authoritative Information',
	        204 => 'No Content',
	        205 => 'Reset Content',
	        206 => 'Partial Content',
	        300 => 'Multiple Choices',
	        301 => 'Moved Permanently',
	        302 => 'Found',
	        303 => 'See Other',
	        304 => 'Not Modified',
	        305 => 'Use Proxy',
	        307 => 'Temporary Redirect',
	        400 => 'Bad Request',
	        401 => 'Unauthorized',
	        402 => 'Payment Required',
	        403 => 'Forbidden',
	        404 => 'Not Found',
	        405 => 'Method Not Allowed',
	        406 => 'Not Acceptable',
	        407 => 'Proxy Authentication Required',
	        408 => 'Request Time-out',
	        409 => 'Conflict',
	        410 => 'Gone',
	        411 => 'Length Required',
	        412 => 'Precondition Failed',
	        413 => 'Request Entity Too Large',
	        414 => 'Request-URI Too Large',
	        415 => 'Unsupported Media Type',
	        416 => 'Requested Range Not Satisfiable',
	        417 => 'Expectation Failed',
	        500 => 'Internal Server Error',
	        501 => 'Not Implemented',
	        502 => 'Bad Gateway',
	        503 => 'Service Unavailable',
	        504 => 'Gateway Time-out',
	        505 => 'HTTP Version Not Supported',
    	);
		header('HTTP/1.1 '.$num.' '.$http[$num]); 				
		http_response_code($num);
		echo json_encode([ "status" => $http[$num] ]);
		die;
	}

	private function parseRequestBody($array, $separator){
		$string = '';
		$tmpstr = [];
		$i = 0;
		if($array && is_array($array)){
			foreach ($array as $key => $value) {
				$tmpstr[$i] = "`".$key."`='".$value."'";
				$i++;
			}
			$string .= " ".implode(" ".$separator." ", $tmpstr);
		}
		return $string;
	}

	private function getUrlPattern(){
		$e = $this -> endpoint;

		if($e == "/api/auth/login" || $e == "/api/auth/logout"){ return $e; }

		$e = explode("?", $e)[0];
		$e = explode("/", $e);
		if(preg_match("/\D/", $e[3]) > 0){ $this -> message(400); }
		$ending = preg_match("/^\d+$/", $e[3]) > 0 ? "/{id}" : "" ;
		return "/".$e[1]."/".$e[2].$ending;
	}

	private function makeQuery(){
		switch ($this -> method) {
			case 'GET':	break; case 'PUT': break; case 'POST': break; case 'DELETE': break;
			default: $this -> message(405); break;
		}
		$m = $this -> endpoint_map[ $this -> getUrlPattern() ][ $this -> method ];
		call_user_func(array($this, $m));
	}

	public function __construct(){

		header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

		global $Router;
		$this -> method = $_SERVER['REQUEST_METHOD'];
		$this -> endpoint = $Router -> url;
		$this -> request_body = json_decode(file_get_contents('php://input'), TRUE);
		
		$this -> makeQuery();

		$this -> sendRequest();
		$this -> getResponse();
	}

	private function login(){
		global $DB;
		$request_body = $_POST ? $_POST : json_decode(file_get_contents('php://input'), TRUE) ;
		$tmp = SHA1($request_body["login"]."-".$request_body["password"]).SALT;
		$this -> response = $DB -> query("SELECT * FROM `users` WHERE `id` IN (SELECT `uid` FROM `auth` WHERE `token`='".$tmp."')");
		$tmparr = array();
		while ($row = $this -> response -> fetch_assoc()) {
			$tmparr = $row;
		}
		if($tmparr){
			$_SESSION['auth'] = $tmparr;
			$this -> message(200);
		} else {
			$this -> message(401);
		}
	}

	private function logout(){
		session_start();
		session_destroy();
		global $DB;
		unset($DB);
		$this -> message(200);
	}

	private function getUserList(){
		global $User;
		$q = "SELECT * FROM `users` ";
		if($User -> isAdmin() || $User -> isEmployee()){
			$q = $q."WHERE `company`='" . $User -> company . "' "; 
		}
		if($_GET['limit']){ $q = $q."LIMIT ".$_GET['limit']." ";}
		if($_GET['offset']){ $q = $q."OFFSET ".$_GET['offset']." ";}

		$this -> query = $q;
	}

	private function getUser(){
		global $Router;
		$q = "SELECT * FROM `users` WHERE `id`='".$Router -> subcomponent."'";
		var_dump($_SESSION);
		$this -> query = $q;
	}

	private function createUser(){
		$q = "";
		$this -> query = $q;
	}
	private function updateUser(){
		$q = "";
		$this -> query = $q;
	}
	private function deleteUser(){
		$q = "";
		$this -> query = $q;
	}

}
?>