function CatalogCreator(catalogURL){
	this.catalogURL = catalogURL;
	var self = this;
	/**
	 * The data retrieved from the server
	 * @type {object[]}
	 */
	var _catalogData = null;

	/**
	 * Fills the options of the combo box with the data obtained from the server
	 * @param {object} result The response got from the server
	 * @param {object} catalog The jQuery object of the <option> target
	 */
	var _fillGrid = function(result, catalog){
		if( result === null || result === undefined || result.length < 1 ){
			notifyError("Ocurrió un error en el servidor. Por favor, inténtelo de nuevo");
			console.warn("No se obtuvo respuesta del servidor");
			return false;
		}
		try{
			_catalogData = result.data.resultSet;
			_catalogData.forEach(element => {
				catalog.append('<option value="' + element.id + '">' + element.nombre + '</option>');
			});
		}catch(err){
			console.error(err);
			notifyError("Ha habido un error inesperado");
			return false;
		}
		return true;
	};

	/**
	 * Fills the combo box iif the data has not been obtained before
	 * @param {object} catalog The jQuery object of the <option> target
	 */
	var _fillIfNeeded = function(catalog){
		if(_catalogData === null){
			_fillCatalog(catalog);
		}
	};

	/**
	 * Gets the catalog's data from the server
	 * @param {object} catalog The jQuery of the <option> target
	 */
	var _fillCatalog = function(catalog){
		$.ajax({
			method: 'GET',
			url: self.catalogURL,
			data: {method: 'getElementsGrid'},
			dataType: 'json',
			success: function(result){
				_alreadyFilled = _fillGrid(result, catalog, self);
			},
			error: function(xhr, textStatus, errorThrown){
				notifyError("Ha habido un error desconocido");
				console.error(textStatus + ": " + errorThrown);
			}
		});
	};

	/**
	 * Gets the catalog of the specified id
	 * @param {number} elementId The element's id
	 * @returns {object} The catalog's data
	 */
	var _findElement = function(elementId){
		return _catalogData.find(element => {
			return element.id === elementId
		});
	}

	this.getCatalogCollection = function(){
		return _catalogData;
	}


	/**
	 * Gets the catalog's data from the server
	 * @param {object} catalog The jQuery of the <option> target
	 */
	this.fillCatalog = _fillCatalog;
	/**
	 * Fills the combo box iif the data has not been obtained before
	 * @param {object} catalog The jQuery object of the <option> target
	 */
	this.fillIfNeeded = _fillIfNeeded;
	/**
	 * Gets the catalog of the specified id
	 * @param {number} elementId The element's id
	 * @returns {object} The catalog's data
	 */
	this.findElement = _findElement;
}