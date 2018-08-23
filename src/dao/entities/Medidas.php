<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Measure extends Entity
{
	public $descripcion;

	function __construct($data)
	{
		if(isset($data['id'])){
			parent::__construct($data['id']);	
		}else{
			parent::__construct(null);
		}
		if(isset($data['descripcion'])){
			$this->descripcion = $data['descripcion'];	
		}else{
			$this->descripcion = null;
		}
	}

	function equals($medida){

		return $medida != null && 
				($medida instanceof Measure) && 
				$this->descripcion == $medida->descripcion;
	}
}
?>