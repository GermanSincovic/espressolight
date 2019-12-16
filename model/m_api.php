<?
/*
	Completed API entity
*/
class API{

	private $method;
	private $component;
	private $subcomponent;
	private $request_body;

	private $query;
	public $response;

	public function __construct($method = false, $component = false, $subcomponent = false, $request_body = false){

		header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

		global $Router;

		$this -> method = $method ? $method : $_SERVER['REQUEST_METHOD'];
		$this -> component = $component ? $component : $Router -> component;
		$this -> subcomponent = $subcomponent ? $subcomponent : $Router -> subcomponent;
		$this -> request_body = $request_body ? $request_body : json_decode(file_get_contents('php://input'), TRUE);
		
		$this -> prepareRequest($this -> method, $this -> component, $this -> subcomponent, $this -> request_body);
		$this -> sendRequest();
		$this -> getResponse();
		// vardump($this -> query);
	}

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

}
?>