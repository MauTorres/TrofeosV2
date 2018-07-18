function GridView(){
	this.elements = null;
	var self = this;
	this.getGrid = function(data, rootURL, actions, table){
		$.when(httpCall('GET', rootURL, data)).done(function(res){
			try{
				var responce = jQuery.parseJSON(res);
				responce.data.actions = actions;
				if(responce.success){
					TableCreator.fillTable(responce.data, table);
					self.elements = responce.data.resultSet;
				}
			}catch(err){
				alert("Ha ocurrido un error en el servidor");
				return;
			}
		});
	};
}