<?
class QUERY{

	private $action 	= '';
	private $selector 	= '*';
	private $suffix		= '';
	private $table 		= '';
	private $params 	= '';
	private $where 		= '';
	private $offset 	= '';
	private $limit 		= '';
	private $sorting 	= '';
	private $query 		= [];

	public function setAction($action = ''){
		$action = strtoupper($action);
		switch ($action) {
			case 'SELECT': $this -> action = $action; 			$this -> suffix = 'FROM'; 	break;
			case 'UPDATE': $this -> action = $action; 			$this -> suffix = ''; 		break;
			case 'INSERT': $this -> action = $action.' INTO'; 	$this -> suffix = ''; 		break;
			case 'DELETE': $this -> action = $action; 			$this -> suffix = 'FROM'; 	break;
			default: $this -> error("Wrong Action in", __FUNCTION__); break;
		}
	}

	public function setSelector($selector = '*'){
		if($selector == '*'){
		} elseif($selector AND !is_array($selector)){
			$this -> selector = '`'.$selector.'`';
		} elseif($selector AND is_array($selector)){
			foreach ($selector as $k => $v) {
				$selector[$k] = '`'.$v.'`';
			}
			$this -> selector = implode(',',$selector);
		} else { 
			$this -> error("Wrong Selector in", __FUNCTION__);
		}
	}

	public function setTable($table = ''){
		if($table){
			$this -> table = '`'.$table.'`';
		} else {
			$this -> error("Wrong Table in", __FUNCTION__);
		}
	}

	public function setParams($params = ''){
		if(is_array($params)){
		    if($params['id']){unset($params['id']);}
		    $tmp = [];
    		foreach ($params as $key => $value) {
    			$tmp[] = "`".$key."`='".$value."'";
    		}
    		$tmp = implode(',', $tmp);
		    $this -> params = 'SET ('.$tmp.')';
		}
	}

	public function setWhere($where = ''){
		if(is_array($where)){
			$tmp = [];
			foreach ($where as $key => $value) {
				$tmp[] = "`".$key."`='".$value."'";
			}
			$tmp = implode(',', $tmp);
			$this -> where = 'WHERE '.$tmp;
		}
	}

	public function setOffset($offset = ''){
		if($offset){ $this -> offset = 'OFFSET '.$offset; }
	}

	public function setLimit($limit = ''){
		if($limit){ $this -> limit = 'LIMIT '.$limit; }
	}

	public function setSorting($sortingBy = '', $sortingDirection = ''){
		if(is_array($sortingBy)){
			foreach ($sortingBy as $k => $v) {
				$sortingBy[$k] = '`'.$v.'`';
			}
			$this -> sorting = 'ORDER BY '.implode(',',$sortingBy);
		}
		switch ($sortingDirection) {
			case '': break;
			case ' ASC': $this -> sorting .= $sorting; break;
			case ' DESC': $this -> sorting .= $sorting; break;
			default: $this -> error("Wrong Sorting Direction in", __FUNCTION__); break;
		}
	}

	public function assembly(){
		array_push($this -> query, $this -> action);
		array_push($this -> query, $this -> selector);
		array_push($this -> query, $this -> suffix);
		array_push($this -> query, $this -> table);
		array_push($this -> query, $this -> params);
		array_push($this -> query, $this -> where);
		array_push($this -> query, $this -> offset);
		array_push($this -> query, $this -> limit);
		array_push($this -> query, $this -> sorting);

		$this -> query = implode(' ', array_filter($this -> query));
		return $this -> query;
	}

	private function error($message, $func){
		trigger_error($message." ".get_class($this)." -> ".$func, E_USER_ERROR);
	}

}
?>