<?
class DB_ENTITY{

		/*
		$query = new Query();
		$query -> setAction();
		$query -> setSelector();
		$query -> setTable();
		$query -> setParams();
		$query -> setWhere();
		$query -> setOffset();
		$query -> setLimit();
		$query -> setSorting();
		return $query -> assembly();
		*/

	public function selectList(){
		global $Auth;
		$query = new Query();
		$query -> setAction('SELECT');
		if($Auth -> getCompanyLimitation()){
			$query -> setSelector($Auth -> getCompanyLimitation());
		}
		$query -> setTable(get_class($this));
		$query -> setParams();
		$query -> setWhere();
		$query -> setOffset();
		$query -> setLimit();
		$query -> setSorting();
		return $query -> assembly();
	}

	public function selectSingle($id){
		$query = "SELECT * FROM `" .get_class($this). "` WHERE `id`='" .$id. "'";
		if ($_SESSION['auth']['company']) {
			$query .= " AND `company`='" . $_SESSION['auth']['company'] . "'";
		}
		return $query;
	}

	public function insert(){
		$query = "INSERT INTO `users` SET";
		foreach (array_keys(get_class_vars(get_class($this))) as $key => $value) {
			var_dump($value);
		}
	}

	public function update(){

	}

	public function delete(){

	}
}
?>