function CatalogCreator(catalogURL){
	this.catalogURL = catalogURL;
	var self = this;
	/**
	 * The data retrieved from the server
	 * @type array
	 */
	var _catalogData = null;

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

	var _fillIfNeeded = function(catalog){
		if(_catalogData === null){
			_fillCatalog(catalog);
		}
	};

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

	var _findElement = function(elementId){
		return _catalogData.find(element => {
			return element.id === elementId
		});
	}

	this.fillCatalog = _fillCatalog;
	this.fillIfNeeded = _fillIfNeeded;
	this.findElement = _findElement;
}