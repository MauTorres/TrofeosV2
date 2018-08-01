<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Categoria extends Entity
{
	public $descripcion;

	function __construct($id, $descripcion)
	{
		parent::__construct($id);
		$this->descripcion = $descripcion;
	}

	function equals($categoria){

		return $categoria != null && 
				($categoria instanceof Categoria) && 
				$this->descripcion == $categoria->descripcion;
	}
}
?>