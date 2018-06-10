UsersView = {
	getUsersGrid: function (){
		$.ajax({
			type:'GET',
			url: '../../src/controller/UsuarioController.php',
			data: {method: 'getUsersGrid'},
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					if(responce.success){
						UsersView.fillUserTable(responce.data);
					}
				}catch(err){
					alert("Ha ocurrido un error en el servidor");
					return;
				}
				//Despliegue de información en la vista				
			},
			//En caso de error se informa al usuario
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				console.log("Error contactando con el servidor");
			}
		});
	},
	fillUserTable: function(data){
		var userTable = $('#user-table');
		var tableBody = userTable.find('tbody');
		this.createHeaders(data.columns, userTable);
		for(var rowsCount = 0; rowsCount < data.resultSet.length; rowsCount++){
			tableBody.append('<tr></tr>');
			var tableRow = tableBody.find('tr');
			var columns = Object.values(data.resultSet[rowsCount]);
			for(var columnCount = 0; columnCount < columns.length; columnCount++){
				$(tableRow[rowsCount]).append('<td>' + columns[columnCount] + '</td>');
			}
		}
	},
	createHeaders: function(headsArray, table){
		var trHeader = table.find('thead').find('tr');
		for(var headsCount = 0; headsCount < headsArray.length; headsCount++){
			trHeader.append('<th scope="col">' + headsArray[headsCount] + '</th>')
		}
	}
};



$.getScript('../js/controller/MenuVars.js', function()
{
    $(document).ready(function(){
		MenuVars.getMenuNavs('usuarios');
		UsersView.getUsersGrid();
	});
});