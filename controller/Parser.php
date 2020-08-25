<?

namespace controller;

use model\API\API_Response;
use mysqli_result;

class Parser{

    /**
     * @param $response mysqli_result
     * @return mixed
     */
	public static function DBResponseToArray($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr[] = $row;
		}
		return Parser::trimPassword($tmparr);
	}

    /**
     * @param $response mysqli_result
     * @return mixed
     */
	public static function DBResponseToArrayWithId($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr[$row["id"]] = $row;
		}
		return $tmparr;
	}

    /**
     * @param $response mysqli_result
     * @return mixed
     */
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

    /**
     * @param $type string id | login | password | email | name | phone | text | boolean
     * @return API_Response
     * @return string
     */
    public static function isValid($type, $target){
        switch ($type){
            case 'id': return preg_match(PATTERN_ID, $target) ? $target : new API_Response(400, "Invalid $type"); break;
            case 'login': return preg_match(PATTERN_LOGIN, $target) ? $target : new API_Response(400, "Invalid $type"); break;
            case 'password': return preg_match(PATTERN_PASSWORD, $target) ? $target : new API_Response(400, "Invalid $type"); break;
            case 'email': return filter_var($target, FILTER_VALIDATE_EMAIL) ? $target : new API_Response(400, "Invalid $type"); break;
            case 'name': return preg_match(PATTERN_NAME, $target) ? $target : new API_Response(400, "Invalid $type"); break;
            case 'phone': return preg_match(PATTERN_PHONE, $target) ? $target : new API_Response(400, "Invalid $type"); break;
            case 'text': return strip_tags($target) == $target ? $target : new API_Response(400, "Invalid $type"); break;
            case 'boolean': return preg_match(PATTERN_BOOLEAN, $target) ? $target : new API_Response(400, "Invalid $type"); break;
        }

    }
}