<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/ColorDao.php";
require_once __DIR__."/CategoriaDao.php";
require_once __DIR__."/MaterialDao.php";
require_once __DIR__."/entities/Elemento.php";
require_once __DIR__."/entities/Trofeo.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class ElementoDao extends DAO
{
	private $colorDao;
	private $categoriaDao;
	private $materialDao;

	function __construct()
	{
		parent::__construct();
		$this->colorDao = new ColorDao();
		$this->categoriaDao = new CategoriaDao();
		$this->materialDao = new MaterialDao();
	}

	public function getElementByElementName($ElementName){
		$elementos = array();
		$result = $this->query("SELECT * FROM elementos WHERE nombre = ?", array($ElementName));
		$result = $result->getResultSet();

		foreach ($result as $elementos) {
			array_push($elementos, new Elemento($result['id'], $result['nombre'], $result['descripcion'], $result['precio'], $result['idColor'], $result['idCategoria'], $result['idMaterial']));
		}

		return $usuarios;
	}

	public function saveElement($elemento){
		try{
			$this->execute("INSERT INTO elementos(nombre, descripcion, precio, idColor, idCategoria, idMaterial) VALUES(?, ?, ?, ?, ?, ?)", array(array($elemento->nombre, $elemento->descripcion, $elemento->precio, $elemento->idColor, $elemento->idCategoria, $elemento->idMaterial)));
		}catch(Exception $e){
			throw $e;
		}
		
	}

	public function getElementsGrid($params){
		$query = sprintf("
			SELECT 
			E.id,
   			E.nombre,
		    E.descripcion,
		    E.precio,
		    C.descripcion AS color,
		    C.id idColor,
		    M.descripcion AS material,
		    M.id idMaterial,
		    Cat.descripcion AS categoria,
		    Cat.id idCategoria
			FROM elementos E
			LEFT JOIN colores C
				ON E.idColor = C.id
			LEFT JOIN materiales M
				ON E.idMaterial = M.id
			LEFT JOIN categorias Cat
				ON E.idCategoria = Cat.id
			WHERE 
				E.estatus = 1
				%s", $params);
		
		return $this->query($query, null);
	}

	public function getElementosTrofeos($params){
		$query = sprintf(
			"SELECT 
				E.id,
	   			E.nombre,
			    IF(C.descripcion is null, '', C.descripcion) AS color,
			    IF(M.descripcion is null, '', M.descripcion) AS material,
			    IF(Cat.descripcion is null, '', Cat.descripcion) AS categoria,
			    (SELECT 
			    	GROUP_CONCAT(Meds.medida SEPARATOR '|')
			   	FROM medidas Meds
			   	WHERE Meds.idElemento = E.id
			   	GROUP BY Meds.idElemento) AS medidas
			FROM elementos E
			LEFT JOIN colores C
				ON E.idColor = C.id
			LEFT JOIN materiales M
				ON E.idMaterial = M.id
			LEFT JOIN categorias Cat
				ON E.idCategoria = Cat.id
			WHERE 
				E.estatus = 1
				%s", $params);

		return $this->query($query, null);
	}

	public function getElementosTrofeo($trofeo){
		$query = sprintf(
			"SELECT 
				E.id,
	   			E.nombre,
			    IF(C.descripcion is null, '', C.descripcion) AS color,
			    IF(M.descripcion is null, '', M.descripcion) AS material,
			    IF(Cat.descripcion is null, '', Cat.descripcion) AS categoria,
			    (SELECT 
			    	GROUP_CONCAT(Meds.medida SEPARATOR '|')
			   	FROM medidas Meds
			   	WHERE Meds.idElemento = E.id
			   	GROUP BY Meds.idElemento) AS medidas
			FROM elementos E
			LEFT JOIN colores C
				ON E.idColor = C.id
			LEFT JOIN materiales M
				ON E.idMaterial = M.id
			LEFT JOIN categorias Cat
				ON E.idCategoria = Cat.id
			JOIN trofeoselementos TE
				ON TE.idElemento = E.id
			WHERE 
				E.estatus = 1
				AND TE.idTrofeo = %s", $trofeo->id);

		return $this->query($query, null);
	}

	public function deleteElement($elemento){
		try{
			$this->execute("UPDATE elementos SET estatus = 0 WHERE id = ?", array(array($elemento->id)));
		}catch(Exception $e){
			Loger::log($e->getMessage(),null);
			throw $e;
		}
	}

	public function getElementByID($elemento){
		$result = $this->query("SELECT * FROM elementos WHERE id = ?", array($elemento->id));
		$row = $result->getResultSet()[0];
		if ($row == null) {
			return null;
		}
		$color = $this->colorDao->getColorByID($row['idColor']);
		$categoria = $this->categoriaDao->getCategoryByID($row['idCategoria']);
		$material = $this->materialDao->getMaterialByID($row['idMaterial']);
		return new Elemento($row['id'], $row['nombre'], $row['descripcion'], $row['precio'], $color, $categoria, $material);
	}

	public function createOrUpdateUser($elemento){
		try{
			$elementoNew = $this->getElementByID($elemento);
			if($elemento->nombre != null && $elemento->nombre != '')
				$elementoNew->nombre = $elemento->nombre;
			if($elemento->descripcion != null && $elemento->descripcion != '')
				$elementoNew->descripcion = $elemento->descripcion;
			if($elemento->precio != null && $elemento->precio != '')
				$elementoNew->precio = $elemento->precio;
			if($elemento->idColor != null && $elemento->idColor != '')
				$elementoNew->idColor = $elemento->idColor;
			if($elemento->idCategoria != null && $elemento->idCategoria != '')
				$elementoNew->idCategoria = $elemento->idCategoria;
			if($elemento->idMaterial != null && $elemento->idMaterial != '')
				$elementoNew->idMaterial = $elemento->idMaterial;

			$this->execute(
				"UPDATE elementos 
				SET 
					nombre = ?,
					descripcion = ?,
					precio = ?,
					idColor = ?,
					idCategoria = ?,
					idMaterial = ?
				WHERE id = ?", 
				array(array($elementoNew->nombre, $elementoNew->descripcion, $elementoNew->precio, $elementoNew->idColor,  $elementoNew->idCategoria,  $elementoNew->idMaterial, $elementoNew->id)));
		}catch(Exception $e){
			Loger::log($e->getMessage(),null);
			throw $e;
		}	
	}
}
?>