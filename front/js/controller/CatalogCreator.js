function CatalogCreator(catalogURL){
	var self = this;
	this.catalogData
	this.catalogURL = catalogURL;
	this.fillCatalog = function(catalog){
		$.ajax({
			method: 'GET',
			url: self.catalogURL,
			data: {method: 'getElementsGrid'},
			success: function(result){
				if( result === null || result === undefined || result.length < 1 ){
					notifyError("Ocurrió un error en el servidor. Por favor, inténtelo de nuevo");
					console.warn("No se obtuvo respuesta del servidor");
					return false;
				}
				try{
					self.catalogData = jQuery.parseJSON(result);
					self.catalogData = self.catalogData.data.resultSet;
					for(var elementCount = 0; elementCount < self.catalogData.length; elementCount++){
						var element = self.catalogData[elementCount];
						catalog.append('<option value="' + element.id + '">' + element.descripcion + '</option>');
					}
				}catch(err){
					console.error(err);
					notifyError("Ha habido un error inesperado");
				}
			},
			error: function(xhr, textStatus, errorThrown){
				notifyError("Ha habido un error desconocido");
				console.error(textStatus + ": " + errorThrown);
			}
		});
	};
}