<?php
/**
* 
*/
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/VistasDAO.php";

class VistasBusiness extends Business
{
	
	private $vistasDAO;

	function __construct()
	{
		parent::__construct();
		$this->vistasDAO = new VistasDAO();
	}

	public function getVistasAll(){
		$this->responce = new Responce();
		$result = $this->vistasDAO->getVistasAll();

		$this->responce->success = true;
		$this->responce->data = $result->getResultSet();
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}
}
?>