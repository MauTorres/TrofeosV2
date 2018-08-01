<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/entities/Categoria.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class CategoriaDao extends DAO
{

	function __construct()
	{
		parent::__construct();
	}

	public function getCategoryByCategoryDescription($categoryName){
		$category = array();
		$result = $this->query("SELECT * FROM categorias WHERE descripcion = ?", array($categoryName));
		$result = $result->getResultSet();

		foreach ($result as $category) {
			array_push($category, new Categoria($result['id'], $result['descripcion']));
		}

		return $category;
	}

	public function saveCategory($category){
		try{
			$this->execute("INSERT INTO categorias(descripcion) VALUES(?)", array(array($category->descripcion)));
		}catch(Exception $e){
			Loger::log($e->getMessage(), null);
			throw $e;
		}
		
	}

	public function getCategoriesGrid($params){
		try{
			$query = sprintf("SELECT 
					Cat.id,
					Cat.descripcion
				FROM categorias Cat
				WHERE
					estatus = 1
					%s", $params);
			return $this->query($query, null);
		}catch(Exception $e){
			Loger::log($e->getMessage(), null);
			throw $e;
		}
		
	}

	public function deleteCategory($category){
		try{
			$this->execute("UPDATE categorias SET estatus = 0 WHERE id = ?", array(array($category->id)));
		}catch(Exception $e){
			Loger::log($e->getMessage(), null);
			throw $e;
		}
	}

	public function getCategoryByID($category){
		$result = $this->query("SELECT * FROM categorias WHERE id = ?", array($category->id));
		$row = $result->getResultSet();

		return new Categoria($row['id'], $row['descripcion']);
	}

	public function createOrUpdateCategory($category){
		try{
			$categoryNew = $this->getCategoryByID($category);
			if($category->descripcion != null && $category->descripcion != '')
				$categoryNew->descripcion = $category->descripcion;
			
			$this->execute(
				"UPDATE categorias 
				SET 
					descripcion = ?
				WHERE id = ?", 
				array(array($categoryNew->descripcion, $categoryNew->id)));
		}catch(Exception $e){
			Loger::log($e->getMessage(), null);
			throw $e;
		}	
	}
}
?>