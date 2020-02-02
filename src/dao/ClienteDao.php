<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Cliente.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class ClienteDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getUserByBussinessName($bName){
		$clientes = array();
		$result = $this->query("SELECT * FROM Clientes WHERE nombre = ?", array($bName));
		$result = $result->getResultSet();

		foreach ($result as $cliente) {
			array_push($clientes, new Cliente($cliente['id'], $cliente['nombre'], $cliente['vendedorInt']));
		}

		return $clientes;
	}

	public function saveUser($cliente){
		try{
			$this->execute(
				"INSERT INTO Clientes(nombre, direccion, vendedorInt) 
				VALUES(:nombre, :direccion, :vendedorInt)", 
				array(
					":nombre"=>$cliente->nombre, 
					":direccion"=>$cliente->direccion, 
					":vendedorInt"=>$cliente->vendedorInt
				)
			);
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getUsersGrid($params){
		$query = sprintf("SELECT 
				id,
				nombre,
				direccion,
				vendedorInt
			FROM Clientes 
			WHERE
				estatus = 1
				%s", $params);
		return $this->query($query, null);
	}

	public function deleteUser($cliente){
		try{
			$this->execute("UPDATE Clientes SET estatus = 0 WHERE id = :id", array(":id"=>$cliente->id));
		}catch(Exception $e){
			throw $e;
		}
	}

	public function getUserByID($cliente){
		$result = $this->query("SELECT * FROM Clientes WHERE id = ?", array($cliente->id));
		$row = $result->getResultSet()[0];

		return new Cliente($row['id'], $row['nombre'], $row['direccion'], $row['vendedorInt']);
	}

	public function createOrUpdateUser($cliente){
		try{
			if($cliente->id == null){
				$this->saveUser($cliente);
				return;
			}

			$clienteNew = $this->getUserByID($cliente);
			if($cliente->nombre != null && $cliente->nombre != '')
				$clienteNew->nombre = $cliente->nombre;
			if($cliente->direccion != null && $cliente->direccion != '')
				$clienteNew->direccion = $cliente->direccion;
			if($cliente->vendedorInt != null && $cliente->vendedorInt != '')
				$clienteNew->vendedorInt = $cliente->vendedorInt;

			$this->execute(
				"UPDATE Clientes 
				SET 
					nombre = :nombre,
					direccion = :direccion,
					vendedorInt = :vendedorInt
				WHERE id = :id",
				array(
					":usuario"=>$clienteNew->usuario, 
					":direccion"=>$clienteNew->direccion, 
					":vendedorInt"=>$clienteNew->vendedorInt,
					":id"=>$clienteNew->id
				)
			);
		}catch(Exception $e){
			throw $e;
		}	
	}
}
?>