<?
class DB_ENTITY{

	private function makeQuery($adds){
		$query = new Query();
		$query -> setAction($adds['action']);
		$query -> setSelector($adds['selector']);
		$query -> setTable($adds['table']);
		$query -> setParams($adds['params']);
		$query -> setWhere($adds['where']);
		$query -> setOffset($adds['offset']);
		$query -> setLimit($adds['limit']);
		$query -> setSorting($adds['sorting']['sorting_by'], $adds['sorting']['sortingDirection']);
		return $query -> assembly();
	}

	
	/*
		private function packEntity(){}

		private function getAll(){}
	*/ 

	public function get($adds = []){
		$adds['action'] = 'SELECT';
		$adds['table'] = get_class($this);
		return $this -> makeQuery($adds);
	}

	public function create($adds = []){
		if( !$adds['params'] ){ $query -> error('Need to provide PARAMS', __FUNCTION__); }
		$adds['action'] = 'INSERT';
		$adds['table'] = get_class($this);
		return $this -> makeQuery($adds);
	}

	public function update($adds = []){
		if( !$adds['params'] OR !$adds['where'] ){ $query -> error('Need to provide PARAMS and WHERE', __FUNCTION__); }
		$adds['action'] = 'UPDATE';
		$adds['table'] = get_class($this);
		return $this -> makeQuery($adds);
	}

	public function delete($adds = []){
		if( !$adds['where'] ){ $query -> error('Need to provide WHERE', __FUNCTION__); }
		$adds['action'] = 'DELETE';
		$adds['table'] = get_class($this);
		return $this -> makeQuery($adds);
	}
}
?>