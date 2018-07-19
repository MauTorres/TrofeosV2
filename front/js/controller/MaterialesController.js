var catalogosController = new CatalogosController();

$(document).ready(function(){
	CatalogosView.rootURL = '../../src/controller/MaterialController.php';
	SessionController.checkSession('materiales');
	CatalogosView.getCatalogosGrid({method: 'getElementsGrid'});
});
