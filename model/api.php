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
		return $response;
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
	private function outputResponse(){

		echo json_encode( $this -> response );
	}


	







	// Main methods
	private function login(){
		global $DB;
		$request_body = $_POST ? $_POST : json_decode(file_get_contents('php://input'), TRUE) ;
		$tmp = "SELECT * FROM `users` WHERE `token`='".SHA1($request_body["login"]."-".$request_body["password"]).SALT."'";
		$this -> response = $DB -> query($tmp);
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

	private function getList($arr = []){
		$this -> query_arr['action'] = 'SELECT';
		$this -> query_arr['selector'] = '*';
		$this -> query_arr['limit'] = $this -> request_params_limit;
		$this -> query_arr['offset'] = $this -> request_params_offset;
		$this -> query_arr['sorting'] = $this -> request_params_sorting;
	}
	private function get(){
		$arr['action'] = 'SELECT';
		$this -> query_arr = $arr;
	}
	private function create(){
		$arr['action'] = 'INSERT';
		$this -> query_arr = $arr;
	}
	private function update(){
		$arr['action'] = 'UPDATE';
		$this -> query_arr = $arr;
	}
	private function delete(){
		$arr['action'] = 'DELETE';
		$arr['selector'] = '*';
		$this -> query_arr = $arr;
	}

	private function getUserList(){
		global $Parser;
		$this -> getList();
		$this -> query_arr['where'] = $this -> request_params_where;
		$this -> query_arr['table'] = 'users';
		$this -> response = $Parser -> DBResponseToArrayWithId( $this -> sendRequest() );
	}

}
?>