function CatalogCreator(catalogURL){
	var self = this;
	this.catalogData
	this.catalogURL = catalogURL;
	this.fillCatalog = function(catalog){
		$.when(httpCall('GET', self.catalogURL, {method: 'getElementsGrid'})).done(function(result){
			try{
				self.catalogData = jQuery.parseJSON(result);
				self.catalogData = self.catalogData.data.resultSet;
				for(var elementCount = 0; elementCount < self.catalogData.length; elementCount++){
					var element = self.catalogData[elementCount];
					catalog.append('<option value="' + element.id + '">' + element.descripcion + '</option>');
				}
			}catch(err){
				SessionController.sessionFailed("Ocurrió un error en el servidor");
			}
		});
	};
}