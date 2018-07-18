var colorCatalogCreator = new CatalogCreator('../../src/controller/ColorController.php');
var materialCatalogCreator = new CatalogCreator('../../src/controller/MaterialController.php');
var categoriaCatalogCreator = new CatalogCreator('../../src/controller/CategoryController.php');

$(document).ready(function(){
	colorCatalogCreator.fillCatalog($('#color'));
	materialCatalogCreator.fillCatalog($('#material'));
	categoriaCatalogCreator.fillCatalog($('#categoria'));
});