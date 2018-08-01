<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class VistasDAO extends DAO
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function getVistasAll(){
		return $this->query("SELECT * FROM vistas WHERE estatus = 1", null);
	}
}
?>