<?
class Query{

	private $action 	= '';
	private $selector 	= '';
	private $suffix		= '';
	private $table 		= '';
	private $join 		= '';
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

	public function setSelector($selector = ''){
		if($selector AND is_array($selector) AND !empty($selector)){
			foreach ($selector as $k => $v) {
				$selector[$k] = ''.$v.'';
			}
			$this -> selector = implode(',',$selector);
		} elseif($this -> action == 'SELECT') {
			$this -> selector = '*';
		}
	}

	public function setTable($table = ''){
		if($table){
			$this -> table = $table;
		} else {
			$this -> error("Wrong Table in", __FUNCTION__);
		}
	}

	public function setJoin($join = ''){
		if($join AND $this -> action == 'SELECT'){
			$this -> join = $join;
		}
	}

	public function setParams($params = ''){
		global $Auth;
		if(is_array($params)){
		    $tmp = [];
    		foreach ($params as $key => $value) {
    			$tmp[] = "`".$key."`='".$value."'";
    		}
    		$tmp = implode(',', $tmp);
		    $this -> params = 'SET '.$tmp;
		}
	}

	public function setWhere($where = ''){
		$tmp = [];
		if(is_array($where) AND $where AND $this -> action != 'INSERT INTO'){
			foreach ($where as $key => $value) {
				$tmp[] = "".$key."='".$value."'";
			}
			$tmp = implode(' AND ', $tmp);
			$this -> where = 'WHERE '.$tmp;
		}
	}

	public function setSorting($sortingBy = '', $sortingDirection = ''){
		if(!is_array($sortingBy) AND !empty($sortingBy)){
			$sortingBy = explode(',', $sortingBy);
		}
		if(is_array($sortingBy)){
			foreach ($sortingBy as $k => $v) {
				$sortingBy[$k] = '`'.$v.'`';
			}
			$this -> sorting = 'ORDER BY '.implode(',',$sortingBy);
		}
		switch (strtoupper($sortingDirection)) {
			case '': break;
			case 'ASC': $this -> sorting .= ' '.strtoupper($sortingDirection); break;
			case 'DESC': $this -> sorting .= ' '.strtoupper($sortingDirection); break;
			default: $this -> error("Wrong Sorting Direction in", __FUNCTION__); break;
		}
	}

	public function setLimit($limit = ''){
		if($limit){ $this -> limit = 'LIMIT '.$limit; }
	}

	public function setOffset($offset = ''){
		if($offset){ $this -> offset = 'OFFSET '.$offset; }
	}

	public function assembly(){
		array_push($this -> query, $this -> action);
		array_push($this -> query, $this -> selector);
		array_push($this -> query, $this -> suffix);
		array_push($this -> query, $this -> table);
		array_push($this -> query, $this -> join);
		array_push($this -> query, $this -> params);
		array_push($this -> query, $this -> where);
		array_push($this -> query, $this -> sorting);
		array_push($this -> query, $this -> limit);
		array_push($this -> query, $this -> offset);

		$this -> query = implode(' ', array_filter($this -> query));
		return $this -> query;
	}

	private function error($message, $func){
		trigger_error($message." ".get_class($this)." -> ".$func, E_USER_ERROR);
	}

}
?>