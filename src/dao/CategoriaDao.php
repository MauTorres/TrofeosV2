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

	public function getCategoryByCategoryName($categoryName){
		$category = array();
		$result = $this->query("SELECT * FROM categorias WHERE descripcion = ?", array($categoryName));
		$result = $result->getResultSet();

		foreach ($result as $category) {
			array_push($category, new Category($category['id'], $category['descripcion']));
		}

		return $category;
	}

	public function saveCategory($category){
		try{
			$this->execute("INSERT INTO categorias(descripcion,) VALUES(?)", array(array($category->descripcion)));
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getCategorysGrid($params){
		$query = sprintf("SELECT 
				id,
				descripcion
			FROM categorias 
			WHERE
				estatus = 1
				%s", $params);
		Loger::log($query, null);
		return $this->query($query, null);
	}

	public function deleteCategory($category){
		try{
			$this->execute("UPDATE categorias SET estatus = 0 WHERE id = ?", array(array($category->id)));
		}catch(Exception $e){
			throw $e;
		}
	}

	public function getCategoryByID($category){
		$result = $this->query("SELECT * FROM categorias WHERE id = ?", array($category->id));
		$row = $result->getResultSet()[0];

		return new Category($row['id'], $row['descripcion']);
	}

	public function createOrUpdateCategory($category){
		try{
			if($category->id == null){
				$this->saveCategory($category);
				return;
			}

			$categoryNew = $this->getCategoryByID($category);
			if($category->descripcion != null && $category->descripcion != '')
				$categoryNew->descripcion = $category->descripcion;
			
			$this->execute(
				"UPDATE categorias 
				SET 
					descripcion = ?,
				WHERE id = ?", 
				array(array($categoryNew->descripcion, $categoryNew->id)));
		}catch(Exception $e){
			throw $e;
		}	
	}
}
?>