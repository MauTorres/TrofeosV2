<?php
/**
 * 
 */
require_once __DIR__."/Constants.php";

class FileManager
{
	private $file;
	function __construct($file){
		$this->file = $file;
	}

	public function saveImage(){
		$target = dirname(__DIR__).STORE_PATH.$this->file['name'];
		move_uploaded_file($this->file['tmp_name'], $target);
	}
}
?>
