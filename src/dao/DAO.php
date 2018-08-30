<?php
/**
* 
*/
require_once dirname(__DIR__)."/utils/Connection.php";
require_once __DIR__."/utilities/DBResponce.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class DAO
{
	private $connection;

	function __construct()
	{
		$this->connection = Connection::getInstance();
	}

	public function query($query, $variablesArr){
		try{
			$statement = $this->connection->getConnection()->prepare($query);
			if($variablesArr == null)
				$statement->execute();
			else
				$statement->execute($variablesArr);
			return new DBResponce($statement);
		}catch(Exception $exception){
			throw $exception;
		}
	}

	public function multiQuery($query, $variablesArr){
		try{
			$statement = $this->connection->getConnection()->prepare($query);

			$results = array();
			foreach ($variablesArr as $vars){
				$statement->execute($vars);
				array_push($results, new DBResponce($statement));
			}
			return $results;
		}catch(Exception $exception){
			throw $exception;
		}
	}

	public function execute($query, $variablesArr){
		try{
			$statement = $this->connection->getConnection()->prepare($query);
			
			if($variablesArr != null){
				foreach ($variablesArr as $key => $value) {
					$statement->bindValue($key, $value, $this->getDataType($value));
				}
			}

			$statement->execute();
		}catch(Exception $exception){
			throw $exception;
		}	
	}

	private function getDataType($data){
		if(is_int($data)){
			return PDO::PARAM_INT;
		}else if(is_bool($data)){
			return PDO::PARAM_BOOL;
		}else if($data == null || $data == ""){
			return PDO::PARAM_NULL;
		}
		return PDO::PARAM_STR;
	}
}
?>