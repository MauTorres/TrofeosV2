var catalogosController = new CatalogosController();

$(document).ready(function(){
	CatalogosView.rootURL = '../../src/controller/MeasureController.php';
	SessionController.checkSession('medidas');
	CatalogosView.getCatalogosGrid({method: 'getElementsGrid'});
});
