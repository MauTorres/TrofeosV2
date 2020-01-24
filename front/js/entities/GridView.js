function GridView(){
	this.elements = null;
	this.headers = null;
	var self = this;

	var _fillTable = function(data, table, elementsToDisplay){
		console.log(data);
		TableCreator.fillTable(data, table, elementsToDisplay);
		self.elements = data.resultSet;
		self.elements.forEach(function(element){
			element.selected = false;
		});
	};

	var _fillGridFromCatalog = function(catalogCreator, rootURL, table, elementsToDisplay){
		var catalog = catalogCreator.getCatalogCollection();
		if( catalog === null ){
			catalog = new Object();
		}
		$.ajax({
			method: 'get',
			url: '../../src/controller/' + rootURL,
			data: {method: 'request_fields'},
			dataType: 'json',
			success: function(response){
				if(response.success){
					response.data.actions = catalogCreator.getActions();
					_fillTable(response.data, table, elementsToDisplay);
				}
			},
			error: function(xhr, textStatus, errorThrown){
				notifyError("Ha habido un error desconocido");
				console.error(textStatus + ": " + errorThrown);
			}
		});
	};

	var _getGrid = function(data, rootURL, actions, table, elementsToDisplay){
		$.ajax({
			method: 'get',
			url: rootURL,
			data: data,
			dataType: 'json',
			success: function(response){
				if(response.success){
					response.data.actions = actions;
					_fillTable(response.data, table, elementsToDisplay);
				}
			},
			error: function(xhr, textStatus, errorThrown){
				notifyError("Ha habido un error desconocido");
				console.error(textStatus + ": " + errorThrown);
			}
		});
	};

	this.fillTable = _fillTable;
	this.getGrid = _getGrid;
	this.fillGridFromCatalog = _fillGridFromCatalog;
}