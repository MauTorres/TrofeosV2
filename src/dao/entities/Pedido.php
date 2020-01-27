<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Pedido extends Entity
{
	public $id;
	public $folio;
	public $fElaboracion;
	public $fEntrega;
	public $subtotal;
	public $total;
	public $idCliente;
	public $IdUsuario;
	public $trofeos;

	function __construct($id = null){
		parent::__construct($id);
	}

	function equals($folio){
		return $folio != null && 
				($folio instanceof Pedido) && 
				$this->Folio == $folio->Folio &&
				$this->fElaboracion == $folio->fElaboracion;
				$this->fEntrega == $folio->fEntrega;
				$this->subtotal == $folio->subtotal;
				$this->total == $folio->total;
				$this->idCliente == $folio->idCliente;
				$this->IdUsuario == $folio->IdUsuario;
	}
}
?>