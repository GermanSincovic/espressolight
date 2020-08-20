<?
class Parser{
	
	public static function DBResponseToArray($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr[] = $row;
		}
		return Parser::trimPassword($tmparr);
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
        foreach ($parsed_array['varsPath'] as $k => $v){
            $parsed_array['urlPattern'][$k] = preg_replace("/^\d+$/", "{id}", $v);
        }
        if( $parsed_array['urlPattern']){
            $parsed_array['urlPattern'] = implode("/",$parsed_array['urlPattern']);
        } else {
            $parsed_array['urlPattern'] = "";
        }
        return $parsed_array;
    }

    public static function vardump($e){
        echo '<pre>';
        print_r($e);
        echo '</pre>';
    }

    public static function debug($e){
        print_r($e);
        die();
    }

    public static function trimPassword($data){
	    if($data[0]){
	        foreach($data as $k => $v){
                unset($data[$k]['user_password']);
            }
        } else {
            unset($data['user_password']);
        }
	    return $data;
    }

    public static function getAnnotationInfo($className){
        $rc = new ReflectionClass($className);
        $annotation = $rc->getDocComment();
        $data = preg_replace('/[\/\s\*]/', "", $annotation);
        $data = preg_split("/@/", $data, 0, PREG_SPLIT_NO_EMPTY);
        foreach ($data as $v) {
            $tmp = explode("=", $v);
            $res[$tmp[0]] = $tmp[1];
        }
        if(!$res){ return false; }
        return $res;
    }

    public static function isValid($type, $target){

	    $idPattern          = "/^\d+$/";
	    $loginPattern       = "/^[A-Za-z_0-9-]{6,20}$/";
	    $passwordPattern    = "/^[A-Za-z_0-9-]{8,32}$/";
	    $namePattern        = "/^[A-Za-zА-Яа-я ']{2,}$/";
	    $phonePattern       = "/^\d{12}$/";

        switch ($type){
            case 'id': return preg_match($idPattern, $target) ? true : new API_Response(400, ["message" => "Invalid $type"]); break;
            case 'login': return preg_match($loginPattern, $target) ? true : new API_Response(400, ["message" => "Invalid $type"]); break;
            case 'password': return preg_match($passwordPattern, $target) ? true : new API_Response(400, ["message" => "Invalid $type"]); break;
            case 'email': return filter_var($target, FILTER_VALIDATE_EMAIL) ? true : new API_Response(400, ["message" => "Invalid $type"]); break;
            case 'name': return preg_match($namePattern, $target) ? true : new API_Response(400, ["message" => "Invalid $type"]); break;
            case 'phone': return preg_match($phonePattern, $target) ? true : new API_Response(400, ["message" => "Invalid $type"]); break;
            case 'text': return strip_tags($target) == $target ? true : new API_Response(400, ["message" => "Invalid $type"]); break;
        }

    }
}