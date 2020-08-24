<?

namespace utils;

class Query{

	private static $action 	        = '';
	private static $selector 	    = '';
	private static $suffix		    = '';
	private static $table 		    = '';
	private static $join 		    = '';
	private static $params 	        = '';
	private static $where 		    = '';
	private static $offset 	        = '';
	private static $limit 		    = '';
	private static $sorting 	    = '';
	private static $query 	        = [];

	public static function init(){
        $clazz = get_called_class();
        return new $clazz();
    }

    public function setAction($action = ''){
		$action = strtoupper($action);
		switch ($action) {
			case 'SELECT':
            case 'DELETE': self::$action = $action; 			self::$suffix = 'FROM'; 	break;
            case 'UPDATE': self::$action = $action; 			self::$suffix = ''; 		break;
            case 'INSERT': self::$action = $action.' INTO'; 	self::$suffix = ''; 		break;
			default: $this -> error("Wrong Action in", __FUNCTION__); break;
		}
		return $this;
	}

	public function setSelector($selector = ''){
		if($selector AND is_array($selector) AND !empty($selector)){
			foreach ($selector as $k => $v) {
				$selector[$k] = ''.$v.'';
			}
            self::$selector = implode(',',$selector);
		} elseif(self::$action == 'SELECT' OR self::$action == 'DELETE') {
            self::$selector = '*';
		}
        return $this;
	}

	public function setTable($table = ''){
		if($table){
            self::$table = $table;
		} else {
			$this -> error("Wrong Table in", __FUNCTION__);
		}
        return $this;
	}

	public function setJoin($join = ''){
		if($join AND self::$action == 'SELECT'){
            self::$join = $join;
		}
        return $this;
	}

	public function setParams($params = ''){
		if(is_array($params)){
		    $tmp = [];
    		foreach ($params as $key => $value) {
    			$tmp[] = "`".$key."`='".$value."'";
    		}
    		$tmp = implode(',', $tmp);
            self::$params = 'SET '.$tmp;
		}
        return $this;
	}

	public function setWhere($where = ''){
		$tmp = [];
		if(is_array($where) AND $where AND self::$action != 'INSERT INTO'){
			foreach ($where as $key => $value) {
				$tmp[] = "".$key."='".$value."'";
			}
			$tmp = implode(' AND ', $tmp);
            self::$where = 'WHERE '.$tmp;
		}
        return $this;
	}

	public function setSorting($sortingBy = '', $sortingDirection = ''){
		if(!is_array($sortingBy) AND !empty($sortingBy)){
			$sortingBy = explode(',', $sortingBy);
		}
		if(is_array($sortingBy)){
			foreach ($sortingBy as $k => $v) {
				$sortingBy[$k] = '`'.$v.'`';
			}
            self::$sorting = 'ORDER BY '.implode(',',$sortingBy);
		}
		switch (strtoupper($sortingDirection)) {
			case '': break;
            case 'DESC':
            case 'ASC': self::$sorting .= ' '.strtoupper($sortingDirection); break;
            default: $this -> error("Wrong Sorting Direction in", __FUNCTION__); break;
		}
        return $this;
	}

	public function setLimit($limit = ''){
		if($limit){ self::$limit = 'LIMIT '.$limit; }
        return $this;
	}

	public function setOffset($offset = ''){
		if($offset){ self::$offset = 'OFFSET '.$offset; }
        return $this;
	}

	public static function assembly(){
		array_push(self::$query, self::$action);
		array_push(self::$query, self::$selector);
		array_push(self::$query, self::$suffix);
		array_push(self::$query, self::$table);
		array_push(self::$query, self::$join);
		array_push(self::$query, self::$params);
		array_push(self::$query, self::$where);
		array_push(self::$query, self::$sorting);
		array_push(self::$query, self::$limit);
		array_push(self::$query, self::$offset);

        self::$query = implode(' ', array_filter(self::$query));
		return self::$query;
	}

	private function error($message, $func){
		trigger_error($message." ".get_class($this)." -> ".$func, E_USER_ERROR);
	}

}