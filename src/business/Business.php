<?php
/**
* 
*/
require_once dirname(__DIR__)."/utils/Loger.php";
require_once dirname(__DIR__)."/utils/Responce.php";

class Business
{
	private $responce;
	function __construct()
	{
		$this->responce = new Responce();
	}
}
?>