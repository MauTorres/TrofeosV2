<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Cliente extends Entity
{
	public $nombre;
	public $direccion;
	public $vendedorInt;

	function __construct($id, $nombre, $direccion, $vendedorInt)
	{
		parent::__construct($id);
		$this->nombre = $nombre;
		$this->direccion = $direccion;
		$this->vendedorInt = $vendedorInt;
	}

	function equals($nombre){

		return $nombre != null && 
				($nombre instanceof Cliente) && 
				$this->nombre == $nombre->nombre &&
				$this->direccion == $nombre->direccion &&
				$this->vendedorInt == $nombre->vendedorInt;
	}
}
?>