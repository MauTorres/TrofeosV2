<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Elemento extends Entity
{
	public $nombre;
	public $descripcion;
	public $precio;
	public $idColor;
	public $idDeporte;
	public $idMaterial;

	function __construct($id, $nombre, $descripcion, $precio, $idColor, $idDeporte, $idMaterial)
	{
		parent::__construct($id);
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->precio = $precio;
	}

	function equals($material){

		return $material != null && 
				($material instanceof Material) && 
				$this->nombre == $material->nombre &&
				$this->descripcion == $material->descripcion &&
				$this->precio == $material->precio;
	}
}
?>