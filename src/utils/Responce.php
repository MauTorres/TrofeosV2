<?php
/**
* 
*/
class Responce
{
	public $success;
	public $message;
	public $data;

	function __construct(){
		$this->success = true;
		$this->message = null;
		$this->data = null;
	}
}
?>