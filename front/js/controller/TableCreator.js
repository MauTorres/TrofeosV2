TableCreator = {
	header: '<thead></thead>',
	body:'<tbody></tbody>',
	createHeaders: function(data, table){
		table.append(TableCreator.header);		
		var trHeader = table.find('thead');
		trHeader.append('<tr></tr>');
		trHeader = trHeader.find('tr');
		for(var headsCount = 0; headsCount < data.columns.length; headsCount++){
			trHeader.append('<th scope="col">' + data.columns[headsCount] + '</th>');
		}
		if(data.actions != undefined)
			trHeader.append('<th scope="col">Acciones</th>');
	},
	fillUserTable: function(data, table){
		TableCreator.cleanTable(table);
		TableCreator.createHeaders(data, table);
		table.append(TableCreator.body);
		var tableBody = table.find('tbody');
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
				actions[actionsCount].size,
				actions[actionsCount].functionECute);
			buttons += button.mold;
		}
		tableRow.append('<td>' + buttons + '</td>');
	},
	cleanTable: function(table){
		table.html('');
	}
};
