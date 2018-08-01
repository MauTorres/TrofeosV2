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
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function setElement($trofeo, $elemento){
		$this->responce = new Responce();
		try{
			$this->trofeoDAO->setElement($trofeo, $elemento);
			$this->responce->success = true;
			$this->responce->message = "Se ha registrado el elemento ".$elemento->id;
		}catch(Exception $e){
			throw new Exception("Falló en insertar el elemento ".$elemento->id);	
		}

		//echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function setElements($trofeo, $elementos){
		try {
			if(count($elementos) == 0)
				throw new Exception('No hay elementos que agregar a éste trofeo');	
			foreach ($elementos as $elemento) {
				$this->setElement($trofeo, $elemento);
			}
		} catch (Exception $e) {
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		$this->responce->success = true;
		$this->responce->message = "Elementos insertados con éxito";
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}
}
?>