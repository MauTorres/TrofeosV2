TableCreator = {
	createHeaders: function(data, table){
		var trHeader = table.find('thead').find('tr');
		for(var headsCount = 0; headsCount < data.columns.length; headsCount++){
			trHeader.append('<th scope="col">' + data.columns[headsCount] + '</th>');
		}
		if(data.actions != undefined)
			trHeader.append('<th scope="col">Acciones</th>');
	},
	fillUserTable: function(data, table){
		var userTable = table;
		var tableBody = userTable.find('tbody');
		TableCreator.createHeaders(data, userTable);
		for(var rowsCount = 0; rowsCount < data.resultSet.length; rowsCount++){
			tableBody.append('<tr></tr>');
			var tableRow = tableBody.find('tr');
			var columns = Object.values(data.resultSet[rowsCount]);
			var row = $(tableRow[rowsCount]);
			for(var columnCount = 0; columnCount < columns.length; columnCount++){
				row.append('<td>' + columns[columnCount] + '</td>');
			}
			if(data.actions != undefined)
				TableCreator.createActions(data.actions, row);
		}
	},
	createActions: function(actions, tableRow){
		var buttons = '';
		for(var actionsCount = 0; actionsCount < actions.length; actionsCount++){
			var button = new ActionButton(
				actions[actionsCount].type, 
				actions[actionsCount].label, 
				actions[actionsCount].icon, 
				actions[actionsCount]._class,
				actions[actionsCount].size);
			buttons += button.mold;
		}
		tableRow.append('<td>' + buttons + '</td>');
	}
};
