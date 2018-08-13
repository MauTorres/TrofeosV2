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

	function __construct($data)
	{
		if(isset($data['id'])){
			parent::__construct($data['id']);	
		}else{
			parent::__construct(null);
		}
		if(isset($data['nombre'])){
			$this->nombre = $data['nombre'];	
		}else{
			$this->nombre = null;
		}
		if(isset($data['descripcion'])){
			$this->descripcion = $data['descripcion'];	
		}else{
			$this->descripcion = null;
		}
		if(isset($data['precio'])){
			$this->precio = $data['precio'];
		}else{
			$this->precio = null;
		}
		if(isset($data['idColor'])){
			$this->idColor = $data['idColor'];
		}else{
			$this->idColor = null;
		}
		if(isset($data['idCategoria'])){
			$this->idCategoria = $data['idCategoria'];
		}else{
			$this->idCategoria = null;
		}
		if(isset($data['idMaterial'])){
			$this->idMaterial = $data['idMaterial'];
		}else{
			$this->idMaterial = null;
		}
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