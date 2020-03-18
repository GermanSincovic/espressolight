<?
class Parser{
	
	public function DBResponseToArray($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr[] = $row;
		}
		return $tmparr;
	}

	public function DBResponseToArrayWithId($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr[$row["id"]] = $row;
		}
		return $tmparr;
	}

	public function DBResponseToArraySingle($response){
		$tmparr = array();
		while ($row = $response -> fetch_assoc()) {
			$tmparr = $row;
		}
		return $tmparr;
	}

	public function makeToken($l, $p){
		return SHA1($l."-".$p."-".SALT);
	}

}