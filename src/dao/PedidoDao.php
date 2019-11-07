<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/ClienteDao.php";
require_once __DIR__."/entities/Cliente.php";
require_once __DIR__."/entities/Pedido.php";
require_once __DIR__."/entities/Usuario.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class PedidoDao extends DAO
{
	private $clienteDao;
	private $usuarioDao;

	function __construct()
	{
		parent::__construct();
		$this->clienteDao = new ClienteDao();
		$this->usuarioDao = new UsuarioDao();
	}

	public function getElementByElementFolio($ElementFolio){
		$pedidos = array();
		$result = $this->query("SELECT * FROM Pedidos WHERE Folio = ?", array($ElementFolio));
		$result = $result->getResultSet();

		foreach ($result as $pedido) {
			array_push($pedidos, new Pedido($pedido));
		}

		return $pedidos;
	}

	public function saveElement($pedido){
		try{
			Loger::log("Pedido a guardar: ".print_r($pedido, 1), null);
			$this->execute(
				"INSERT INTO Pedidos(Folio, fElaboracion, fEntrega, subtotal, total, idCliente, IdUsuario) 
				VALUES(:Folio, :fElaboracion, :fEntrega, :subtotal, :total, :idCliente, :IdUsuario)", 
				array(
					":Folio"=>$pedido->Folio, 
					":fElaboracion"=>$pedido->fElaboracion, 
					":fEntrega"=>$pedido->fEntrega, 
					":subtotal"=>$pedido->subtotal, 
					":total"=>$pedido->total, 
					":idCliente"=>$pedido->idCliente,
					":IdUsuario"=>$pedido->IdUsuario
				)
			);
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getElementsGrid($params){
		$query = sprintf("
			SELECT 
				P.id,
	   			P.Folio,
			    P.fElaboracion,
			    P.fEntrega,
		    	P.subtotal,
	   			P.total,
			    IF(Cl.nombre is null, '', Cl.nombre) AS cliente,
			    IF(U.usuario is null, '', U.usuario) AS usuario,
			FROM Pedidos P
			LEFT JOIN Clientes Cl
				ON P.idCliente = Cl.id
			LEFT JOIN usuarios U
				ON P.IdUsuario = U.id
			WHERE 
				P.estatus = 1
				%s", $params);
		
		return $this->query($query, null);
	}

	/*public function setMeasure($pedido, $medida){
		try {
			$this->execute(
				'INSERT INTO medidas(idElemento, idTipoMedida, medida) VALUES(:idElemento, :idTipoMedida, :medidaDesc)', 
				array(
					":idElemento"=>$pedido->id, 
					":idTipoMedida"=>$medida->id,
					":medidaDesc" => $medida->descripcion
				)
			);
		} catch (Exception $e) {
			Loger::log($e->getMessage(), null);
			throw $e;
		}
	}
*/
	public function getElementosTrofeos($params){
		$query = sprintf("
			SELECT 
				P.id,
	   			P.Folio,
			    P.fElaboracion,
			    P.fEntrega,
		    	P.subtotal,
	   			P.total,
			    IF(Cl.nombre is null, '', Cl.nombre) AS cliente,
			    IF(U.usuario is null, '', U.usuario) AS usuario,
			FROM Pedidos P
			LEFT JOIN Clientes Cl
				ON P.idCliente = Cl.id
			LEFT JOIN usuarios U
				ON P.IdUsuario = U.id
			WHERE 
				P.estatus = 1
				%s", $params);
		
		return $this->query($query, null);
	}

	public function getElementosPedido($pedido){
		$query = sprintf("
			SELECT 
				P.id,
	   			P.Folio,
			    P.fElaboracion,
			    P.fEntrega,
		    	P.subtotal,
	   			P.total,
			    IF(Cl.nombre is null, '', Cl.nombre) AS cliente,
			    IF(U.usuario is null, '', U.usuario) AS usuario,
			FROM Pedidos P
			LEFT JOIN Clientes Cl
				ON P.idCliente = Cl.id
			LEFT JOIN usuarios U
				ON P.IdUsuario = U.id
			JOIN TrofeosPedidos TP
				ON TP.idPedido = P.id
			WHERE 
				P.estatus = 1
				AND TP.idTrofeo = %s", $trofeo->id);

		return $this->query($query, null);
	}

	public function deleteElement($pedido){
		try{
			$this->execute("UPDATE Pedidos SET estatus = 0 WHERE id = :id", array(":id"=>$pedido->id));
		}catch(Exception $e){
			Loger::log($e->getMessage(),null);
			throw $e;
		}
	}

	public function getElementByID($pedido){
		$result = $this->query("SELECT * FROM Pedidos WHERE id = ?", array($pedido->id));
		$row = $result->getResultSet()[0];
		if ($row == null) {
			return null;
		}
		$cliente = $this->clienteDao->getUserByBussinessName( new Cliente($row['idCliente'], NULL) );
		$usuario = $this->usuarioDao->getUserByUserName( new Usuario($row['IdUsuario'], NULL ));
		return new Pedido($row);
	}

	public function createOrUpdateElement($pedido){
		try{
			$pedidoNew = $this->getElementByElementFolio($pedido);
			if($pedido->Folio != null && $pedido->Folio != '')
				$pedidoNew->Folio = $pedido->Folio;
			if($pedido->fElaboracion != null && $pedido->fElaboracion != '')
				$pedidoNew->fElaboracion = $pedido->fElaboracion;
			if($pedido->fEntrega != null && $pedido->fEntrega != '')
				$pedidoNew->fEntrega = $pedido->fEntrega;
			if($pedido->subtotal != null && $pedido->subtotal != '')
				$pedidoNew->subtotal = $pedido->subtotal;
			if($pedido->total != null && $pedido->total != '')
				$pedidoNew->total = $pedido->total;
			if($pedido->idCliente != null && $pedido->idCliente != '')
				$pedidoNew->idCliente = $pedido->idCliente;
			if($pedido->IdUsuario != null && $pedido->IdUsuario != '')
				$pedidoNew->IdUsuario = $pedido->IdUsuario;

			$this->execute(
				"UPDATE Pedidos 
				SET 
					Folio = :Folio,
					fElaboracion = :fElaboracion,
					fEntrega = :fEntrega,
					subtotal = :subtotal,
					total = :total,
					idCliente = :idCliente,
					IdUsuario = :IdUsuario
				WHERE id = :id", 
				array(
					":Folio"=>$pedidoNew->Folio, 
					":fElaboracion"=>$pedidoNew->fElaboracion, 
					":fEntrega"=>$pedidoNew->fEntrega, 
					":subtotal"=>$pedidoNew->subtotal, 
					":total"=>$pedidoNew->total, 
					":idCliente"=>$pedidoNew->idCliente, 
					":IdUsuario"=>$pedidoNew->IdUsuario, 
					":id"=>$pedidoNew->id
				)
			);
		}catch(Exception $e){
			Loger::log($e->getMessage(),null);
			throw $e;
		}	
	}
}
?>
