<?php
/**
* 
*/
require_once __DIR__."/Business.php";
require_once dirname(__DIR__)."/dao/ClienteDAO.php";

class ClienteBusiness extends Business
{
	private $ClienteDAO;
	private $responce;

	function __construct()
	{
		parent::__construct();
		$this->ClienteDAO = new ClienteDAO();
	}

	public function saveUser($client){
		$this->responce = new Responce();
		try{
			$this->ClienteDAO->saveUser($client);
			$this->responce->success = true;
			$this->responce->message = "El cliente se guardó correctamente";
		}catch(Exception $e){
			Loger::log("Error al dar de alta al cliente ".$client->nombre."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = "Error al agregar al cliente ".$client->nombre;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
		
	}

	public function getUsersGrid($nombre){
		$this->responce = new Responce();
		$params = "";
		if($nombre != null){
			if($nombre->id != null)
				$params .= "AND id = ".$nombre->id;
			if($nombre->nombre != null)
				$params .= "AND nombre like '%".$nombre->nombre."%'";
			if($nombre->direccion != null)
				$params .= "AND direccion like '%".$nombre->direccion."%'";
			if($nombre->vendedorInt != null)
				$params .= "AND vendedorInt like '%".$nombre->vendedorInt."%'";
		}

		$result = $this->ClienteDAO->getUsersGrid($params);
		$this->responce->success = true;
		$this->responce->data = $result;

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE); 
	}

	public function deleteUser($nombre){
		$this->responce = new Responce();
		try{
			$this->ClienteDAO->deleteUser($nombre);
			$this->responce->success = true;
			$this->responce->message = "El cliente se se dio de baja correctamente";
		}catch(Exception $e){
			$this->responce->success = false;
			$this->responce->message = "Error al eliminar al cliente ".$client->nombre;
		}
		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}

	public function createOrUpdateUser($nombre){
		$this->responce = new Responce();
		
		try{
			if($nombre->id == null || $nombre->id == ''){
				$result = $this->ClienteDAO->getUserByBussinessName($nombre->razonSoc);
				$clientsCount = count($result);
				if($clientsCount > 0)
					throw new Exception("Ya hay un cliente con la misma razon social");
			}

			$this->ClienteDAO->createOrUpdateUser($nombre);
			$this->responce->success = true;
			$this->responce->message = "El cliente se registró correctamente";
		}catch(Exception $e){
			Loger::log("Error al actualizar al nombre ".$nombre->nombre."\n".$e->getMessage(), null);
			$this->responce->success = false;
			$this->responce->message = $e->getMessage();
		}

		echo json_encode($this->responce, JSON_UNESCAPED_UNICODE);
	}
}
?>