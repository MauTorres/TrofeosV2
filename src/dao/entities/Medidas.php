<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Measure extends Entity
{
	public $descripcion;

	function toString(){
		return "Measure[id=$this->id, descripcion=$this->descripcion]";
	}

	function __construct($id, $descripcion)
	{
		parent::__construct($id);
		$this->descripcion = $descripcion;
	}

	function equals($medida){

		return $medida != null && 
				($medida instanceof Measure) && 
				$this->descripcion == $medida->descripcion;
	}
}
?>