<?
class Parser{
	
	public function DBResponseToArray($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr[] = $row;
		}
		return $tmparr;
	}

	public function DBResponseToArrayWithId($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr[$row["id"]] = $row;
		}
		return $tmparr;
	}

	public function DBResponseToArraySingle($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr = $row;
		}
		return $tmparr;
	}

	public function getEndpointUrlPattern($url){
		$e = $url;

		if($e == "/api/v1/auth/login" || $e == "/api/v1/auth/logout"){ return $e; }

		$e = explode("?", $e)[0];
		$e = explode("/", $e);
		if(preg_match("/\D/", $e[3]) > 0){ 
			return false; 
		}
		$ending = preg_match("/^\d+$/", $e[3]) > 0 ? "/{id}" : "" ;
		return "/".$e[1]."/".$e[2].$ending;
	}

	public function makeToken($l, $p){
		return SHA1($l."-".$p."-".SALT);
	}

}