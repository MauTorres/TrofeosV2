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
	public $idCategoria;
	public $idMaterial;

	function __construct($id, $nombre, $descripcion, $precio, $idColor, $idCategoria, $idMaterial)
	{
		parent::__construct($id);
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->precio = $precio;
		$this->idColor = $idColor;
		$this->idCategoria = $idCategoria;
		$this->idMaterial = $idMaterial;
	}

	function equals($elemento){

		return $elemento != null && 
				($elemento instanceof Elemento) && 
				$this->nombre == $elemento->nombre &&
				$this->descripcion == $elemento->descripcion &&
				$this->precio == $elemento->precio &&
				$this->idColor == $idColor &&
				$this->idCategoria == $idCategoria &&
				$this->idMaterial == $idMaterial;
	}
}
?>