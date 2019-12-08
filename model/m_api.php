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

		$this -> method = $_SERVER['REQUEST_METHOD'];
		$this -> request_url = $Router -> path;
		$this -> request_body = json_decode(file_get_contents('php://input'), TRUE);
		switch ($this -> method) {
			case 'GET': $this -> executeGET(); break;
			case 'POST': $this -> executePOST(); break;
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

	private function executePOST(){
		global $Router;
		if ($Router -> subcomponent){
			$q = "UPDATE `".$Router -> component."` SET ";
			$tmpcol = []; $i = 0;
			foreach($this -> request_body as $key => $value){
				if(is_array($key) || is_array($value)){ $this -> error(400); }
				$tmpcol[$i] = "`".$key."`='".$value."'";
				$i++;
			}
			$q = $q.implode(", ", $tmpcol)." WHERE `id`='".$Router -> subcomponent."'";
			$this -> sendRequest($q);
		} else {
			$this -> error(400);
		}
	}

	private function sendRequest($query){
		global $DB;
		$res = $DB -> query($query);
		if($DB -> errno) { $this -> error(400); }
		echo $this -> formatResponse($res);
	}

	private function formatResponse($arr){
		global $DB;
		if($this -> method == "POST" && !$DB -> errno){
			return json_encode(["status"=>'OK']);
		} else {
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

	private function error($num){
		http_response_code($num);
		die;
	}

}
?>