<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/ColorDao.php";
require_once __DIR__."/CategoriaDao.php";
require_once __DIR__."/MaterialDao.php";
require_once __DIR__."/MedidaDao.php";
require_once __DIR__."/entities/Elemento.php";
require_once __DIR__."/entities/Trofeo.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class ElementoDao extends DAO
{
	private $colorDao;
	private $categoriaDao;
	private $materialDao;
	private $medidaDao;

	function __construct()
	{
		parent::__construct();
		$this->colorDao = new ColorDao();
		$this->categoriaDao = new CategoriaDao();
		$this->materialDao = new MaterialDao();
		$this->medidaDao = new MedidaDao();
	}

	public function getElementByElementName($ElementName){
		$elementos = array();
		$result = $this->query("SELECT * FROM elementos WHERE nombre = ?", array($ElementName));
		$result = $result->getResultSet();

		foreach ($result as $elemento) {
			array_push($elementos, new Elemento($elemento));
		}

		return $elementos;
	}

	public function saveElement($elemento){
		try{
			Loger::log("Elemento a guardar: ".print_r($elemento, 1), null);
			$this->execute(
				"INSERT INTO elementos(nombre, descripcion, idColor, idCategoria, idMaterial) 
				VALUES(:nombre, :descripcion, :idColor, :idCategoria, :idMaterial)", 
				array(
					":nombre"=>$elemento->nombre, 
					":descripcion"=>$elemento->descripcion, 
					":idColor"=>$elemento->idColor, 
					":idCategoria"=>$elemento->idCategoria, 
					":idMaterial"=>$elemento->idMaterial
				)
			);
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
		    	E.id,
	   			E.nombre,
	   			E.descripcion,
			    IF(C.descripcion is null, '', C.descripcion) AS color,
			    IF(M.descripcion is null, '', M.descripcion) AS material,
			    IF(Cat.descripcion is null, '', Cat.descripcion) AS categoria,
			    (SELECT 
			    	GROUP_CONCAT(Meds.medida SEPARATOR '; ')
			   	FROM medidas Meds
				   WHERE Meds.idElemento = E.id
				   AND Meds.estatus = 1
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

	public function setMeasure($elemento, $medida){
		try {
			$this->execute(
				'INSERT INTO medidas(idElemento, idTipoMedida, medida) VALUES(:idElemento, :idTipoMedida, :medidaDesc)', 
				array(
					":idElemento"=>$elemento->id, 
					":idTipoMedida"=>$medida->id,
					":medidaDesc" => $medida->descripcion
				)
			);
		} catch (Exception $e) {
			Loger::log($e->getMessage(), null);
			throw $e;
		}
	}

	public function getElementosTrofeos($params){
		$query = sprintf(
			"SELECT 
				E.id,
	   			E.nombre,
	   			E.descripcion,
			    IF(C.descripcion is null, '', C.descripcion) AS color,
			    IF(M.descripcion is null, '', M.descripcion) AS material,
			    IF(Cat.descripcion is null, '', Cat.descripcion) AS categoria,
			    (SELECT 
			    	GROUP_CONCAT(Meds.medida SEPARATOR '; ')
			   	FROM medidas Meds
			   	WHERE Meds.idElemento = E.id
				   AND Meds.estatus = 1
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
			    E.descripcion,
			    IF(C.descripcion is null, '', C.descripcion) AS color,
			    IF(M.descripcion is null, '', M.descripcion) AS material,
			    IF(Cat.descripcion is null, '', Cat.descripcion) AS categoria,
			    (SELECT 
			    	GROUP_CONCAT(Meds.medida SEPARATOR '; ')
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
			JOIN TrofeosElementos TE
				ON TE.idElemento = E.id
			WHERE 
				E.estatus = 1
				AND TE.idTrofeo = %s", $trofeo->id);

		return $this->query($query, null);
	}

	public function deleteElement($elemento){
		try{
			$this->execute("UPDATE elementos SET estatus = 0 WHERE id = :id", array(":id"=>$elemento->id));
		}catch(Exception $e){
			Loger::log($e->getMessage(),null);
			throw $e;
		}
	}

	public function deleteElementMeasure($elemento, $medida){
		try{
			$this->execute("UPDATE medidas SET estatus = 0 WHERE idElemento = :idElem AND medida = :medida AND id = :id", array(":idElem"=>$elemento->id, ":medida"=>$medida->descripcion, ":id"=>$medida->id));
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
		$color = $this->colorDao->getColorByID( new Color($row['idColor'], NULL) );
		$categoria = $this->categoriaDao->getCategoryByID( new Categoria($row['idCategoria'], NULL ));
		$material = $this->materialDao->getMaterialByID(new Material($row['idMaterial'], NULL));
		$medida = $this->medidaDao->getMeasureByID(new Measure($row['idMedida'], NULL ));
		return new Elemento($row);
	}

	public function createOrUpdateElement($elemento){
		try{
			$elementoNew = $this->getElementByID($elemento);
			if($elemento->nombre != null && $elemento->nombre != '')
				$elementoNew->nombre = $elemento->nombre;
			if($elemento->descripcion != null && $elemento->descripcion != '')
				$elementoNew->descripcion = $elemento->descripcion;
			if($elemento->idColor != null && $elemento->idColor != '')
				$elementoNew->idColor = $elemento->idColor;
			if($elemento->idCategoria != null && $elemento->idCategoria != '')
				$elementoNew->idCategoria = $elemento->idCategoria;
			if($elemento->idMaterial != null && $elemento->idMaterial != '')
				$elementoNew->idMaterial = $elemento->idMaterial;
			if($elemento->idMedida != null && $elemento->idMedida != '')
				$elementoNew->idMedida = $elemento->idMedida;

			$this->execute(
				"UPDATE elementos 
				SET 
					nombre = :nombre,
					descripcion = :descripcion,
					idColor = :idColor,
					idCategoria = :idCategoria,
					idMaterial = :idMaterial
				WHERE id = :id", 
				array(
					":nombre"=>$elementoNew->nombre, 
					":descripcion"=>$elementoNew->descripcion, 
					":idColor"=>$elementoNew->idColor, 
					":idCategoria"=>$elementoNew->idCategoria, 
					":idMaterial"=>$elementoNew->idMaterial, 
					":id"=>$elementoNew->id
				)
			);
		}catch(Exception $e){
			Loger::log($e->getMessage(),null);
			throw $e;
		}	
	}
}
?>
