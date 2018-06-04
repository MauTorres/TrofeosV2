<?php
require_once __DIR__."/src/dao/CatalogoDAO.php";
require_once __DIR__."/src/dao/UsuarioDAO.php";

/*$catalogoDao = new CatalogoDAO();
$catalogo = $catalogoDao->getCatalog('colores');
foreach ($catalogo as $elemento) {
	print_r($elemento->descripcion);
	echo "</br>";
}
print_r(json_encode($catalogo));*/

$usuarioDAO = new UsuarioDAO();
$usuario = new Usuario(null, 'mrTona', 'root', 'yahuitl.trejo@gmil.com');
$usuarioDAO->saveUser($usuario);
?>