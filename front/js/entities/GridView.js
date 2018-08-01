function GridView(){
	this.elements = null;
	var self = this;
	this.getGrid = function(data, rootURL, actions, table, elementsToDisplay){
		$.when(httpCall('GET', rootURL, data)).done(function(res){
			try{
				var responce = jQuery.parseJSON(res);
				responce.data.actions = actions;
				if(responce.success){
					TableCreator.fillTable(responce.data, table, elementsToDisplay);
					self.elements = responce.data.resultSet;
					self.elements.forEach(function(element){
						element.selected = false;
					});
				}
			}catch(err){
				alert("Ha ocurrido un error en el servidor\n" + err);
				return;
			}
		});
	};
}