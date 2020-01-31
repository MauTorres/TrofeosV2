function GridView(){
	/**
	 * Stores the currently available items in the DB
	 * @type {array}
	 */
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
		elementId = Number(elementId);
		//Tests whether the element to add is already in the table
		var existingElement = this.elements.findIndex(element => {
			return element.id === elementId;
		});
		if(existingElement !== -1){
			//Check if the element were deleted temporarily
			if(_tempCollection !== null ){
				var delIndex = _tempCollection.findIndex(element =>{
					return element.catalog.id === elementId;
				});
				if(delIndex !== -1 && _tempCollection[delIndex].action === "delete"){
					//if so, the element exists in the stored collection
					var storedElement = this.elements.find(element => {
						return element.id === elementId;
					});
					TableCreator.addRow(storedElement, _getTableObject(), _elementsToDisplay, _actions);
					_tempCollection.splice(delIndex, 1);
				} else {
					notifyWarning("El elemento \"" + 
						this.elements[existingElement].descripcion +
						"\" ya había sido agregado");
				}
				return;
			} else {
				//If there are no queued elements
				notifyWarning("El elemento \"" + 
						this.elements[existingElement].descripcion +
						"\" ya había sido agregado");
				return;
			}
		}

		if(_tempCollection == null){
			_tempCollection = [];
		} else {
			existingElement = _tempCollection.findIndex(element => {
				return element.catalog.id === elementId;
			});
			if(existingElement !== -1){
				notifyWarning("El elemento \"" + 
					_tempCollection[existingElement].catalog.descripcion +
					"\" ya había sido agregado");
				return;
			}
		}

		var element = _catalogCreator.findElement(elementId);
		_tempCollection.push({'catalog': element, 'action': 'add'});
		TableCreator.addRow(element, _getTableObject(), _elementsToDisplay, _actions);
	};

	/**
	 * Removes an element from the table. This method assumes the element's ID column
	 * exists and it's the first column in the table
	 * @param {jQuery} jQueryRow The jQuery object representing the entire row
	 */
	var _removeElement = function(jQueryRow){
		var elementId = Number(jQueryRow.find("td").first().text());
		if(_tempCollection === null){
			//The element exists in the DB, not in temporal memory
			_tempCollection = [];
			_tempCollection.push({'catalog': {id: elementId}, 'action': 'delete'});
		} else {
			var index = _tempCollection.findIndex(element => {
				return element.catalog.id === elementId;
			});
	
			if(index === -1){
				//The element exists in the DB, not in temporal memory
				_tempCollection.push({'catalog': {id: elementId}, 'action': 'delete'});
			} else {
				//the element exists only in temporal memory
				_tempCollection.splice(index, 1);
			}
		}
        jQueryRow.remove();
    }

	var _fillGridFromCatalog = function(rootURL, catalogId){
		var data = {};
		if(catalogId === undefined){
			data.method = 'request_fields';
		} else {
			data.method = 'get_trophies_by_order';
			data.id = catalogId;
		}
		$.ajax({
			method: 'get',
			url: '../../src/controller/' + rootURL,
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
    
    this.getCollection = function(){
        return _tempCollection;
    }
	

	this.getGrid = _getGrid;
	this.fillGridFromCatalog = _fillGridFromCatalog;
	/**
	 * Adds an element to the grid's table, and marks the item to be updated
	 * when calling the server
	 * @param {number} elementId The ID of the item to add
	 */
	this.addElement = _addElement;
	/**
	 * Removes an element from the table. This method assumes the element's ID column
	 * exists and it's the first column in the table
	 * @param {jQuery} jQueryRow The jQuery object representing the entire row
	 */
	this.removeElement = _removeElement;
}