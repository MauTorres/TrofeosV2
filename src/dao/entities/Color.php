<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Color extends Entity
{
	public $descripcion;

	function toString(){
		return "Color[id=$this->id, descripcion=$this->descripcion]";
	}

	function __construct($id, $descripcion)
	{
		parent::__construct($id);
		$this->descripcion = $descripcion;
	}

	function equals($color){

		return $color != null && 
				($color instanceof Color) && 
				$this->descripcion == $color->descripcion;
	}
}
?>