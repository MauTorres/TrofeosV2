<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Catalogo.php";

class CatalogoDAO extends DAO
{
	
	function __construct()
	{
		parent::__construct();
	}

	public function getCatalog($catalogName){
		$results = $this->query("SELECT * FROM ".$catalogName);
		$catalog = array();
		foreach ($results as $row) {
			array_push($catalog, new Catalogo($row['id'], $row['descripcion']));
		}

		return $catalog;
	}
}
?>