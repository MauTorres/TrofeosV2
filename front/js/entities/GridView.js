function GridView(){
	this.elements = null;
	this.headers = null;
	/**
	 * The actions of the grid
	 * @type {object[]}
	 */
	var _actions = null;

	/**
	 * Saves the pending items to be updated in the server.
	 * @typedef {{
	 *     catalog: {string},
	 *     action: {string}
	 * }}
	 * @type {Array}
	 */
	var _tempCollection = null;
	var self = this;

	var _fillTable = function(data, table, elementsToDisplay){
		TableCreator.fillTable(data, table, elementsToDisplay);
		self.elements = data.resultSet;
		self.elements.forEach(function(element){
			element.selected = false;
		});
	};

	/**
	 * Adds an element to the grid's table, and marks the item to be updated
	 * when calling the server
	 * @param {number} elementId The ID of the item to add
	 * @param {object} catalogCreator The CatalogCreator instance of the items
	 * @param {jQuery} table The jQuery object pointing to the <table> to modify
	 * @param {number[]} elementsToDisplay Array with the indices display in the table
	 */
	var _addElement = function(elementId, catalogCreator, table, elementsToDisplay){
		var element = catalogCreator.findElement(elementId);
		if(_tempCollection == null){
			_tempCollection = [];
		}
		_tempCollection.push({'catalog': element, 'action': 'add'});
		TableCreator.addRow(element, table, elementsToDisplay, _actions);
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
					response.data.actions = _actions;
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

	this.setActions = function(actions){
		_actions = actions;
	}

	this.fillTable = _fillTable;
	this.getGrid = _getGrid;
	this.fillGridFromCatalog = _fillGridFromCatalog;
	/**
	 * Adds an element to the grid's table, and marks the item to be updated
	 * when calling the server
	 * @param {number} elementId The ID of the item to add
	 * @param {object} catalogCreator The CatalogCreator instance of the items
	 * @param {jQuery} table The jQuery object pointing to the <table> to modify
	 * @param {number[]} elementsToDisplay Array with the indices display in the table
	 */
	this.addElement = _addElement;
}