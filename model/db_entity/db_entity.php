<?
class DB_ENTITY{

	public function selectAll(){
		$query = "SELECT * FROM `".get_class($this)."`";
		if ($_SESSION['auth']['company']) {
			$query .= " WHERE `company`='" . $_SESSION['auth']['company'] . "'";
		}
		return $query;
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