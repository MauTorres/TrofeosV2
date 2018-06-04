<?php
/**
* 
*/
class Usuario extends Entity
{
	public $usuario;
	public $passwd;
	public $email;

	function __construct($id, $usuario, $passwd, $email)
	{
		parent::__construct($id);
		$this->usuario = $usuario;
		$this->passwd = $passwd;
		$this->email = $email;
	}
}
?>