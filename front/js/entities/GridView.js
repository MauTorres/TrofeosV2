function GridView(){
	this.elements = null;
	this.headers = null;
	var self = this;

	var _getGrid = function(data, rootURL, actions, table, elementsToDisplay){
		$.ajax({
			method: 'get',
			url: rootURL,
			data: data,
			dataType: 'json',
			success: function(response){
				response.data.actions = actions;
				if(response.success){
					TableCreator.fillTable(response.data, table, elementsToDisplay);
					self.elements = response.data.resultSet;
					self.elements.forEach(function(element){
						element.selected = false;
					});
				}
			},
			error: function(xhr, textStatus, errorThrown){
				notifyError("Ha habido un error desconocido");
				console.error(textStatus + ": " + errorThrown);
			}
		});
	}

	this.getGrid = _getGrid;
}