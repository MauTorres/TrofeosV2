<?php
/**
* 
*/
class Elementos extends Entity
{
	private $nombre;
	private $descripcion;
	private $materiales;
	private $precio;
	private $color;
	private $deporte;
	private $medidas;
	
	function __construct($id, $nombre, $descripcion, $materiales, $precio, $color, $deportes, $medidas)
	{
		parent::__construct($id);
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->materiales = $materiales;
		$this->precio = $precio;
		$this->color = $color;
		$this->deportes = $deportes;
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
	public function setDescripcion($descripcion){
		$this->descripcion = $descripcion;
	}

	public function getMateriales(){
		return $this->materiales;
	}
	public function setMateriales($materiales){
		$this->materiales = $materiales;
	}

	public function getPrecio(){
		return $this->precio;
	}
	public function setPrecio($precio){
		$this->precio = $precio;
	}

	public function getColor(){
		return $this->color;
	}
	public function setColor($color){
		$this->color = $color;
	}

	public function getDeporte(){
		return $this->deporte;
	}
	public function setDeporte($deporte){
		$this->deporte = $deporte;
	}

	public function getMedidas(){
		return $this->deporte;
	}
	public function setMedidas($medidas){
		$this->medidas = $medidas;
	}
}
?>