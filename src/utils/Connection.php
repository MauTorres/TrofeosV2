<?php
/**
* 
*/
require_once dirname(__DIR__)."/utils/ConnectionStrings.php";
//require_once dirname(__DIR__)."\utils\ConnectionStrings.php"; //Windows
class Connection
{
	private $pdoConnection;
	private static $instance = null;
	
	private function __construct()
	{
		$this->pdoConnection = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASSWD);
	}

	public function getInstance(){
		if(self::$instance == null)
			self::$instance = new Connection();
		return self::$instance;
	}

	public function getConnection(){
		return $this->pdoConnection;
	}
}
?>