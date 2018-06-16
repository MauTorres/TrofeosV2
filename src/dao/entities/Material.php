<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Material extends Entity
{
	public $nombre;
	public $descripcion;
	public $precio;

	function __construct($id, $nombre, $descripcion, $precio)
	{
		parent::__construct($id);
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->precio = $precio;
	}

	function equals($material){

		return $material != null && 
				($material instanceof Material) && 
				$this->nombre == $nombre->nombre &&
				$this->descripcion == $descripcion
				->descripcion;
	}
}
?>