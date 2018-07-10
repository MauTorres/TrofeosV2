var catalogosController = new CatalogosController();

$(document).ready(function(){
	CatalogosView.rootURL = '../../src/controller/CategoryController.php';
	SessionController.checkSession('categorias');
	CatalogosView.getCatalogosGrid({method: 'getElementsGrid'});
});
