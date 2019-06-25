<?php
/**
* 
*/
require_once __DIR__."/Entity.php";

class Trofeo extends Entity
{
	public $nombre;
	public $descripcion;
	public $precio;
	public $foto;
	public $estatus;

	function toString(){
		return "Trofeo[id=$this->id, nombre=$this->nombre, descripcion=$this->descripcion, precio=$this->precio, foto=$this->foto, estatus=$this->estatus]";
	}
	
	function __construct($data)
	{
		if(isset($data['id'])){
			parent::__construct($data['id']);
		}
		else{
			parent::__construct(null);
		}

		if(isset($data['nombre'])){
			$this->nombre = $data['nombre'];
		}
		else{
			$this->nombre = null;
		}

		if(isset($data['descripcion'])){
			$this->descripcion = $data['descripcion'];
		}
		else{
			$this->descripcion = null;
		}

		if(isset($data['precio'])){
			$this->precio = $data['precio'];
		}
		else{
			$this->precio = null;
		}

		if(isset($data['foto'])){
			$this->foto = $data['foto'];
		}else if(isset($data['fotoPath'])){
			$this->foto = $data['fotoPath'];
		}else{
			$this->foto = null;
		}

		if(isset($data['estatus'])){
			$this->estatus = $data['estatus'];
		}
		
		else{
			$this->estatus = null;
		}
	}
}
?>