<?php
/**
* 
*/
require_once dirname(__DIR__)."/utils/Connection.php";
require_once dirname(__DIR__)."/utils/ConnectionStrings.php";
require_once __DIR__."/utilities/DBResponce.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class DAO
{
	private $connection;
	private $tableName;

	function __construct($tableName = null)
	{
		$this->connection = Connection::getInstance();
		$this->tableName = $tableName;
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
			Loger::log("[DAO] Ha ocurrido un error: ".$exception, null);
			throw $exception;
		}
	}

	public function getColumnNames(){
		$query = "SELECT `COLUMN_NAME`
            FROM `INFORMATION_SCHEMA`.`COLUMNS`
            WHERE `TABLE_SCHEMA`='".DB_NAME."'
            AND `TABLE_NAME`='$this->tableName'";
		try{
			$statement = $this->connection->getConnection()->prepare($query);
			$statement->execute();

			$result = $statement->fetchAll(PDO::FETCH_ASSOC);
			$names = array();
			for($i = 0; $i < $statement->rowCount(); $i++){
				array_push($names, $result[$i]['COLUMN_NAME']);
			}
			return $names;
		}catch(Exception $exception){
			Loger::log("[DAO] Ha ocurrido un error: ".$exception, null);
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
			if($statement->execute()){
				return true;
			} else {
				Loger::log("[DAO] Ha ocurrido un error. Errno: $statement->errno. $statement->error", null);
				return false;
			}
		}catch(Exception $exception){
			Loger::log("[DAO] Ha ocurrido un error: ".$exception, null);
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