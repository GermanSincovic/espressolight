<?
class API{

	private $method;
	private $endpoint;
	private $request_params_body = [];
	private $request_params_where = [];
	private $request_params_limit = [];
	private $request_params_offset = [];
	private $request_params_sorting = [];
	private $query;
	private $query_arr;
	private $endpoint_map = [];
	public $response;

	public function __construct(){
		
		global $Router;
		global $Parser;

		$this -> method = $_SERVER['REQUEST_METHOD'];
		$this -> endpoint = $Router -> path;
		$this -> endpoint_pattern = $Parser -> getEndpointUrlPattern( $this -> endpoint );
		
		$this -> prepareRequestParamsArray();
		$this -> checkMethod();

		$this -> registerEndpoint("/api/auth/login", "POST", "login");
		$this -> registerEndpoint("/api/auth/logout", "POST", "logout");

		$this -> registerEndpoint("/api/users", "GET", "getUserList");
		$this -> registerEndpoint("/api/users", "PUT", "createUser");
		$this -> registerEndpoint("/api/users/{id}", "GET", "getUser");
		$this -> registerEndpoint("/api/users/{id}", "POST", "updateUser");
		$this -> registerEndpoint("/api/users/{id}", "DELETE", "deleteUser");

		header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

		$this -> executeFunctionByEndpoint( $this -> endpoint_pattern );
		// SMALL or BIG chain of actions!!! 
		$this -> outputResponse();
	}

	private function isLoggedIn(){
		global $Auth;
		if($Auth -> isAnonimous()){
			$this -> message(403);
		}
	}
	private function sendRequest(){
		global $DB;
		$response = $DB -> query( $this -> makeQuery());
		if ($DB -> errno) {
			$this -> message(400);
		}
		if ($DB -> affected_rows == 0) {
			$this -> message(404);
		}
		return $response;
	}
	private function message($num){
		$http = array(
	        200 => 'OK',
	        201 => 'Created',
	        400 => 'Bad Request',
	        401 => 'Unauthorized',
	        402 => 'Payment Required',
	        403 => 'Forbidden',
	        404 => 'Not Found',
	        405 => 'Method Not Allowed',
	        408 => 'Request Time-out',
	        413 => 'Request Entity Too Large',
	        414 => 'Request-URI Too Large',
	        415 => 'Unsupported Media Type',
	        416 => 'Requested Range Not Satisfiable',
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
	private function makeQuery(){
		$adds = $this -> query_arr;
		$query = new Query();
		$query -> setAction($adds['action']);
		$query -> setSelector($adds['selector']);
		$query -> setTable($adds['table']);
		$query -> setParams($adds['params']);
		$query -> setWhere($adds['where']);
		$query -> setSorting($adds['sorting']['sortingBy'], $adds['sorting']['sortingDirection']);
		$query -> setLimit($adds['limit']);
		$query -> setOffset($adds['offset']);
		$this -> query_arr = [];
		return $query -> assembly();
	}
	private function checkMethod(){
		switch ($this -> method) {
			case 'GET':	break;
			case 'PUT': break;
			case 'POST': break;
			case 'DELETE': break;
			default: $this -> message(405); break;
		}
	}
	private function registerEndpoint($endpoint, $method, $function){
		
		$this -> endpoint_map[$endpoint][$method] = $function;
	}
	private function executeFunctionByEndpoint($endpoint){

		call_user_func(array($this, $this -> endpoint_map[ $this -> endpoint_pattern ][ $this -> method ]));
	}
	private function prepareRequestParamsArray(){
		$this -> request_params_body = $_POST ? $_POST : json_decode(file_get_contents('php://input'), TRUE);
		$get = $_GET;
		unset($get['url']);
		if($get['limit'] !== null) { 
			$this -> request_params_limit = $get['limit'];
			unset($get['limit']);
		}
		if($get['offset'] !== null) { 
			$this -> request_params_offset = $get['offset'];
			unset($get['offset']);
		}
		if($get['sortingBy']) { 
			$this -> request_params_sorting['sortingBy'] = $get['sortingBy'];
			unset($get['sortingBy']);
		}
		if($get['sortingDirection']) { 
			$this -> request_params_sorting['sortingDirection'] = $get['sortingDirection'];
			unset($get['sortingDirection']);
		}
		$this -> request_params_where = $get;
	}
	private function convertPasswordToToken(){
		global $Parser;
		$l = $this -> request_params_body['login'];
		$p = $this -> request_params_body['password'];
		unset($this -> request_params_body['password']);
		$this -> request_params_body['token'] = $Parser -> makeToken($l, $p);
	}
	private function outputResponse(){
		global $Parser;
		switch ($this -> method) {
			case 'GET':
				echo json_encode( $Parser -> DBResponseToArrayWithId( $this -> response ) );
				break;
			case 'POST':
				$this -> message(200);
				break;
			case 'PUT':
				$this -> message(201);
				break;
			case 'DELETE':
				$this -> message(200);
				break;
		}
	}

	private function getList(){
		global $Router;
		$this -> query_arr['action'] = 'SELECT';
		$this -> query_arr['table'] = $Router -> component;
		$this -> query_arr['selector'] = '*';
		$this -> query_arr['limit'] = $this -> request_params_limit;
		$this -> query_arr['offset'] = $this -> request_params_offset;
		$this -> query_arr['sorting'] = $this -> request_params_sorting;
	}
	private function get(){
		global $Router;
		$arr['action'] = 'SELECT';
		$arr['table'] = $Router -> component;
		$arr['where']['id'] = $Router -> subcomponent;
		$arr['limit'] = 1;
		$this -> query_arr = $arr;
	}
	private function create(){
		global $Router;
		$arr['action'] = 'INSERT';
		$arr['table'] = $Router -> component;
		$this -> query_arr = $arr;
	}
	private function update(){
		global $Router;
		$arr['action'] = 'UPDATE';
		$arr['table'] = $Router -> component;
		$arr['where']['id'] = $Router -> subcomponent;
		$this -> query_arr = $arr;
	}
	private function delete(){
		global $Router;
		$arr['action'] = 'DELETE';
		$arr['table'] = $Router -> component;
		$arr['where']['id'] = $Router -> subcomponent;
		$this -> query_arr = $arr;
	}

	// Main methods
	private function login(){
		global $DB;
		global $Parser;

		$this -> convertPasswordToToken();

		$this -> query_arr = [];
		$this -> query_arr['action'] = 'SELECT';
		$this -> query_arr['selector'] = '*';
		$this -> query_arr['table'] = 'users';
		$this -> query_arr['where']['token'] = $this -> request_params_body['token'];
		$this -> response = $this -> sendRequest();
		if ($this -> response -> num_rows == 1){
			$_SESSION['auth'] = $Parser -> DBResponseToArraySingle($this -> response);
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
		global $Parser;
		$this -> getList();
		$this -> query_arr['where'] = $this -> request_params_where;
		$this -> response = $this -> sendRequest();
	}
	private function getUser(){
		global $Parser;
		$this -> get();
		$this -> query_arr['where'] = array_merge($this -> query_arr['where'], $this -> request_params_where);
		$this -> response = $this -> sendRequest();
	}
	private function createUser(){
		global $Parser;
		$this -> create();
		$this -> convertPasswordToToken();
		$this -> query_arr['params'] = $this -> request_params_body;
		$this -> response = $this -> sendRequest();
	}
	private function updateUser(){
		$this -> update();
		unset($this -> request_params_body['login']);
		unset($this -> request_params_body['token']);
		$this -> query_arr['params'] = $this -> request_params_body;
		$this -> response = $this -> sendRequest();
	}
	private function deleteUser(){
		global $Parser;
		$this -> delete();
		$this -> query_arr['where'] = array_merge($this -> query_arr['where'], $this -> request_params_where);
		$this -> response = $this -> sendRequest();
	}

}
?>