<?php
/**
* 
*/
class DBResponce
{
	public $table;
	public $columns;
	public $resultSet;

	function __construct($pdoStatement)
	{
		$this->setColumnNames($pdoStatement);
		$this->table = $pdoStatement->getColumnMeta(0)['table'];
		$this->resultSet = $pdoStatement->fetchAll(PDO::FETCH_ASSOC);
	}

	private function setColumnNames($pdoStatement){
		$this->columns = array();
		for($i = 0; $i < $pdoStatement->columnCount(); $i++){
			array_push($this->columns, $pdoStatement->getColumnMeta($i)['name']);
		}
	}

	public function getTableName(){
		return $this->table;
	}

	public function getColumnNames(){
		return $this->columns;
	}

	public function getResultSet(){
		return $this->resultSet;
	}
}
?>