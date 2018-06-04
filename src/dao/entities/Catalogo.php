<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Catalogo extends Entity
{
	public $descripcion;

	function __construct($id, $descripcion)
	{
		parent::__construct($id);
		$this->descripcion = $descripcion;		
	}
}
?>