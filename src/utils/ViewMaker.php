<?php

$parent = dirname(__DIR__);
/*require_once $parent."/DAO/usuariosDAO.php";*/
require_once __DIR__."/Loger.php";

class ViewMaker{
	public static function getNavBarElements($array, $currPage){
		$elements = "";
		//Loger::log(print_r($array, true), null);
		foreach($array as $element){
			if($element == $currPage)
				$elements .= "<a class='nav-item nav-link active' href='#'>".ucfirst($element)."</a>";
			else
				$elements .= "<a class='nav-item nav-link' href='#'>".ucfirst($element)."</a>";
		}
		
		echo $elements;
	}
}
?>