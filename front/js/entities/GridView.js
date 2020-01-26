function GridView(){
	this.elements = null;
	this.headers = null;
	/**
	* Array with the indices display in the table
	* @type {Array}
	 */
	var _elementsToDisplay = null;
	/**
	 * The id of to the <table> to modify
	 * @type {string}
	 */
	var _table = null;

	/**
	 * The CatalogCreator instance of the items
	 */
	var _catalogCreator = null;

	var $table = null;
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

	//**************internal *
	var _fillTable = function(data){
		TableCreator.fillTable(data, _getTableObject(), _elementsToDisplay);
		self.elements = data.resultSet;
		self.elements.forEach(function(element){
			element.selected = false;
		});
	};

	var _getTableObject = function(){
		if($table === null){
			$table = $(_table);
		}
		return $table;
	}

	//**************public

	/**
	 * Adds an element to the grid's table, and marks the item to be updated
	 * when calling the server
	 * @param {number} elementId The ID of the item to add
	 */
	var _addElement = function(elementId){
		var element = _catalogCreator.findElement(elementId);
		if(_tempCollection == null){
			_tempCollection = [];
		}
		_tempCollection.push({'catalog': element, 'action': 'add'});
		TableCreator.addRow(element, _getTableObject(), _elementsToDisplay, _actions);
	};

	var _fillGridFromCatalog = function(rootURL){
		var catalog = _catalogCreator.getCatalogCollection();
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
					_fillTable(response.data);
				}
			},
			error: function(xhr, textStatus, errorThrown){
				notifyError("Ha habido un error desconocido");
				console.error(textStatus + ": " + errorThrown);
			}
		});
	};

	var _getGrid = function(data, rootURL){
		$.ajax({
			method: 'get',
			url: rootURL,
			data: data,
			dataType: 'json',
			success: function(response){
				if(response.success){
					response.data.actions = _actions;
					_fillTable(response.data);
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

	/**
	  @param {number[]} elementsToDisplay Array with the indices display in the table
	 */
	this.setElementsToDisplay = function(elements){
		_elementsToDisplay = elements;
	}

	/**
	 * @param {string} table The id of to the <table> to modify
	 */
	this.setTable = function(table){
		_table = table;
	}

	/**
	 * @param {object} catalogCreator The CatalogCreator instance of the items
	 */
	this.setCatalogCreator = function(creator){
		_catalogCreator = creator;
	}
	

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