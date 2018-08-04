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
	
	function __construct($id, $nombre, $descripcion, $precio, $foto, $estatus)
	{
		parent::__construct($id);
		$this->nombre = $nombre;
		$this->descripcion = $descripcion;
		$this->precio = $precio;
		$this->foto = $foto;
		$this->estatus = $estatus;
	}
}
?>