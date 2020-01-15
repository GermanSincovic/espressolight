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

	public function setAction($action){
		$action = strtoupper($action);
		switch ($action) {
			case 'SELECT': $this -> action = $action; 			$this -> suffix = 'FROM'; 	break;
			case 'UPDATE': $this -> action = $action; 			$this -> suffix = ''; 		break;
			case 'INSERT': $this -> action = $action.' INTO'; 	$this -> suffix = ''; 		break;
			case 'DELETE': $this -> action = $action; 			$this -> suffix = 'FROM'; 	break;
			default: $this -> error("Wrong Action in", __FUNCTION__); break;
		}
	}

	public function setSelector($selector){
		if($selector AND !is_array($selector)){
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

	public function setTable($table){
		if($table){
			$this -> table = '`'.$table.'`';
		} else {
			$this -> error("Wrong Table in", __FUNCTION__);
		}
	}




	public function assembly(){
		array_push($this -> query, $this -> action);
		array_push($this -> query, $this -> selector);
		array_push($this -> query, $this -> suffix);
		array_push($this -> query, $this -> table);

		$this -> query = implode(' ', array_filter($this -> query));
		return $this -> query;
	}

	private function error($message, $func){
		trigger_error($message." ".get_class($this)." -> ".$func, E_USER_ERROR);
	}
}
?>