<?php
/**
* 
*/
class Responce
{
	public $success;
	public $message;
	public $data;

	function toString(){
		return "Responce[success=$this->success, message=$this->message]";
	}

	function __construct(){
		$this->success = true;
		$this->message = null;
		$this->data = null;
	}
}
?>