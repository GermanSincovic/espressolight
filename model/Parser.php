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

	public static function DBResponseToArraySingle($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr = $row;
		}
		return $tmparr;
	}

	public static function arrayToJSON($array){
	    return json_encode($array);
    }

	public static function getPassHash($p){
		return SHA1($p."-".SALT);
	}

	public static function parseUrl(){
	    $parsed_array = [];
        $parsed_array['url'] = $_SERVER['REQUEST_URI'];
        $tmp = explode("?", $parsed_array['url']);
        $parsed_array['path'] = $tmp[0];
        $parsed_array['varsPath'] = preg_split('@/@', $parsed_array['path'], NULL, PREG_SPLIT_NO_EMPTY);
        parse_str($tmp[1], $parsed_array['varsGet']);
        return $parsed_array;
    }

}