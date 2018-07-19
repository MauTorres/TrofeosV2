var catalogosController = new CatalogosController();

$(document).ready(function(){
	CatalogosView.rootURL = '../../src/controller/ColorController.php';
	SessionController.checkSession('colores');
	CatalogosView.getCatalogosGrid({method: 'getElementsGrid'});
});
