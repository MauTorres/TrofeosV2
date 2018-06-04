<?php
/**
* 
*/
class Trofeos extends Entity
{
	private $nombre;
	private $descripcion;
	private $precio;
	private $foto;
	
	function __construct($id, $nombre, $descripcion, $precio, $foto)
	{
		parent::__construct($id);
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->precio = $precio;
		$this->foto = $foto;	
	}

	public function getNombre(){
		return $this->nombre;
	}
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}

	public function getDescripcion(){
		return $this->descripcion;
	}
	public function getDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	public function getPrecio(){
		return $this->precio;
	}
	public function getPrecio($precio){
		$this->precio = $precio;
	}

	public function getFoto(){
		return $this->foto;
	}
	public function getFoto($foto){
		$this->foto = $foto;
	}
}
?>