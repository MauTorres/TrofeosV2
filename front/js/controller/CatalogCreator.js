function CatalogCreator(catalogURL){
	var self = this;
	this.catalogData
	this.catalogURL = catalogURL;
	var _alreadyFilled = false;

	var _fillGrid = function(result, catalog, context){
		if( result === null || result === undefined || result.length < 1 ){
			notifyError("Ocurrió un error en el servidor. Por favor, inténtelo de nuevo");
			console.warn("No se obtuvo respuesta del servidor");
			return false;
		}
		try{
			context.catalogData = jQuery.parseJSON(result);
			context.catalogData = context.catalogData.data.resultSet;
			for(var elementCount = 0; elementCount < context.catalogData.length; elementCount++){
				var element = context.catalogData[elementCount];
				catalog.append('<option value="' + element.id + '">' + element.descripcion + '</option>');
			}
		}catch(err){
			console.error(err);
			notifyError("Ha habido un error inesperado");
			return false;
		}
		return true;
	};

	var _fillIfNeeded = function(catalog){
		if(!_alreadyFilled){
			_fillCatalog(catalog);
		}
	};


	var _fillCatalog = function(catalog){
		$.ajax({
			method: 'GET',
			url: self.catalogURL,
			data: {method: 'getElementsGrid'},
			success: function(result){
				_alreadyFilled = _fillGrid(result, catalog, self);
			},
			error: function(xhr, textStatus, errorThrown){
				notifyError("Ha habido un error desconocido");
				console.error(textStatus + ": " + errorThrown);
			}
		});
	};

	this.fillCatalog = _fillCatalog;
	this.fillIfNeeded = _fillIfNeeded;
}