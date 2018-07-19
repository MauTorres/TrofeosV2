<?php
/**
 * 
 */
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/TrofeoDao.php";

class TrofeoBusiness extends Business
{
	private $trofeoDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->trofeoDAO = new TrofeoDao();
	}

	public function getTrofeosGrid($trofeo){
		$this->responce = new Responce();
		$params = "";
		if($trofeo != null){
			if($trofeo->nombre != null)
				$params .= "AND T.nombre like '%".$trofeo->nombre."%'";
			if($trofeo->precio != null)
				$params .= "AND T.precio = ".$trofeo->precio;
		}
		
		$result = $this->trofeoDAO->getTrofeosGrid($params);
		Loger::log(json_encode($result, JSON_UNESCAPED_UNICODE), null);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}
}
?>