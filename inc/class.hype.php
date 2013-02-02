<?php
class Hype {  

	public $db;
	
	public function Hype() {
		$this->db = Database::obtain();
	}
	
} 