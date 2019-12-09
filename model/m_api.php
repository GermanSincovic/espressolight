<?
class API{

	private $method;
	private $component;
	private $subcomponent;
	private $request_body;

	private $query;
	private $response;

	public function __construct(){
		header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

		global $Router;

		$this -> method = $_SERVER['REQUEST_METHOD'];
		$this -> component = $Router -> component;
		$this -> subcomponent = $Router -> subcomponent;
		$this -> request_body = json_decode(file_get_contents('php://input'), TRUE);
		
		$this -> prepareRequest($this -> method, $this -> component, $this -> subcomponent, $this -> request_body);
		$this -> sendRequest();
		$this -> getResponse();
	}

	private function sendRequest(){
		global $DB;
		$this -> response = $DB -> query($this -> query);
		if ($DB -> errno) {
			$this -> message(500);
			die;
		}
	}

	private function getResponse(){
		global $DB;
		switch ($this -> method) {
			case 'GET': 
				$tmparr = [];
				while ($row = $this -> response -> fetch_assoc()) {
					$tmparr[$row["id"]] = $row;
				}
				echo json_encode($tmparr);
				break;
			case 'POST': $this -> message(200); break;
			case 'PUT': $this -> message(201); break;
			case 'DELETE': $this -> message(200); break;
		}
	}

	private function prepareRequest($method, $component, $subcomponent, $body){
		$q = "";

		// forming ACTION according to METHOD
		switch ($method) {
			case 'GET': $q = "SELECT * FROM "; break;
			case 'POST': $q = "UPDATE "; break; 
			case 'PUT': $q = "INSERT INTO "; break;
			case 'DELETE': $q = "DELETE FROM "; break;
			default: $this -> message(405, "Method Not Allowed"); break;
		}

		// forming TABLE according COMPONENT
		if($component){
			$q .= "`".$component."` ";
		} else {
			$this -> message(400, "Bad Request"); die;
		}

		// forming OPTIONS according REQUEST_BODY
		if($method == "POST" || $method == "PUT"){
			if($body && is_array($body)){
				$tmpstr = [];
				$i = 0;
				foreach ($body as $key => $value) {
					$tmpstr[$i] = "`".$key."`='".$value."'";
					$i++;
				}
				$q .= "SET ".implode(", ", $tmpstr)." ";
			} else {
				$this -> message(400, "Bad Request"); die;
			}
		}

		// forming WHERE-condition according SUBCOMPONENT
		switch ($method) {
			case 'GET': 	if($subcomponent){ $q .= "WHERE `id`=".$subcomponent; } break;
			case 'POST': 	if($subcomponent){ 
								$q .= "WHERE `id`=".$subcomponent; 
							} else {
								$this -> message(400, "Bad Request"); die;
							} break;
			case 'PUT': 	if($subcomponent){ $this -> message(400, "Bad Request"); die; } break;
			case 'DELETE': 	if(!$subcomponent){ 
								$this -> message(400, "Bad Request"); die; 
							} else { 
								$q .= "WHERE `id`=".$subcomponent; 
							} break;
			default: $this -> message(400, "Bad Request"); die; break;
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
		echo json_encode([ "code" => $num, "status" => $http[$num] ]);
	}
}
?>