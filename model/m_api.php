<?
class API{

	private $method;
	private $request_body;
	private $request_url;

	public function __construct(){
		header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

		global $Router;
		// var_dump($Router -> component);
		// var_dump($Router -> subcomponent == '');

		$this -> method = $_SERVER['REQUEST_METHOD'];
		$this -> request_url = $Router -> path;
		$this -> request_body = file_get_contents('php://input');
		switch ($this -> method) {
			case 'GET': $this -> executeGET(); break;
			case 'POST': echo 'POST'; break;
			case 'PUT': echo 'PUT'; break;
			case 'DELETE': echo 'DELETE'; break;
			default: http_response_code(405); die; break;
		}
	}

	private function executeGET(){
		global $Router;
		if ($Router -> subcomponent){
			$this -> sendRequest("SELECT * FROM `".$Router -> component."` WHERE `id`='".$Router -> subcomponent."'");
		}else{
			$this -> sendRequest("SELECT * FROM `".$Router -> component."`");
		}
	}

	private function sendRequest($query){
		global $DB;
		$res = $DB -> query($query);
		if($DB -> errno){
			http_response_code(404);
			die;
		}
		print $this -> formatResponse($res);
	}

	private function formatResponse($arr){
		$tmparr = [];
		if($arr){
			while ($row = $arr->fetch_assoc()) {
				$tmparr[$row["id"]] = $row;
			}
		}
		$JSON = json_encode($tmparr);
		return $JSON;
	} 

}
?>