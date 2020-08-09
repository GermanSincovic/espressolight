<?
class Parser{
	
	public static function DBResponseToArray($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr[] = $row;
		}
		return Parser::noPassword($tmparr);
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
        Parser::vardump($e);
        die();
    }

    public static function noPassword($data){
	    if($data[0]){
	        foreach($data as $k => $v){
                unset($data[$k]['user_password']);
            }
        } else {
            unset($data['user_password']);
        }
	    return $data;
    }
}