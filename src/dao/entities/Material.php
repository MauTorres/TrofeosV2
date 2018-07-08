<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Material extends Entity
{
	public $descripcion;

	function __construct($id, $descripcion)
	{
		parent::__construct($id);
		$this->descripcion = $descripcion;
	}

	function equals($material){

		return $material != null && 
				($material instanceof Material) && 
				$this->descripcion == $material->descripcion;
	}
}
?>