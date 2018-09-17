TableCreator = {
	header: '<thead></thead>',
	body:'<tbody></tbody>',
	createHeaders: function(data, table, elementsToDisplay){
		table.append(TableCreator.header);		
		var trHeader = table.find('thead');
		trHeader.append('<tr></tr>');
		trHeader = trHeader.find('tr');
		var displayCountb = 0;
		for(var headsCount = 0; headsCount < data.columns.length; headsCount++){
			if(headsCount != elementsToDisplay[displayCountb]){
				continue;
			}
			displayCountb++;
			trHeader.append('<th class="nav-item" scope="col">' + data.columns[headsCount] + '</th>');
		}
		if(data.actions != undefined)
			trHeader.append('<th scope="col">Acciones</th>');
	},
	fillTable: function(data, table, elementsToDisplay){
		TableCreator.cleanTable(table);
		TableCreator.createHeaders(data, table, elementsToDisplay);
		table.append(TableCreator.body);
		var tableBody = table.find('tbody');
		for(var rowsCount = 0; rowsCount < data.resultSet.length; rowsCount++){
			var displayCount = 0;
			tableBody.append('<tr></tr>');
			var tableRow = tableBody.find('tr');
			var columns = Object.values(data.resultSet[rowsCount]);
			var row = $(tableRow[rowsCount]);
			for(var columnCount = 0; columnCount < columns.length; columnCount++){
				if(columnCount != elementsToDisplay[displayCount]){
					continue;
				}
				displayCount++;
				row.append('<td>' + columns[columnCount] + '</td>');
			}
			if(data.actions != undefined){
				TableCreator.createActions(data.actions, row);
			}
		}
	},
	updateTable: function(data, table, elementsToDisplay){
		var tableBody = table.find('tbody');
		for(var rowsCount = 0; rowsCount < data.length; rowsCount++){
			var displayCount = 0;
			tableBody.append('<tr></tr>');
			var tableRow = tableBody.find('tr');
			var columns = Object.values(data[rowsCount]);
			var row = $(tableRow[rowsCount]);
			for(var columnCount = 0; columnCount < columns.length; columnCount++){
				if(columnCount != elementsToDisplay[displayCount]){
					continue;
				}
				displayCount++;
				row.append('<td>' + columns[columnCount] + '</td>');
			}
			if(data.actions != undefined)
				TableCreator.createActions(data.actions, row);
		}
	},
	createActions: function(actions, tableRow){
		var buttons = '';
		for(var actionsCount = 0; actionsCount < actions.length; actionsCount++){
			if(actions[actionsCount].component == 'button'){
				var button = new ActionButton(
					actions[actionsCount].type, 
					actions[actionsCount].label, 
					actions[actionsCount].icon, 
					actions[actionsCount]._class,
					actions[actionsCount].size,
					actions[actionsCount].functionECute);
				buttons += button.mold;
			}
			if(actions[actionsCount].component == 'check'){
				var check = new ActionCheck(actions[actionsCount]._class, actions[actionsCount].value, actions[actionsCount].functionECute);
				buttons += check.mold;
			}
		}
		tableRow.append('<td>' + buttons + '</td>');
	},
	cleanTable: function(table){
		table.html('');
	}
};
