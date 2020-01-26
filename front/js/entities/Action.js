function Action(type, label, icon, _class, size, functionECute){
	this.type = type;
	this.label = label;
	this.icon = icon;
	this._class = _class;
	this.size = size;
	this.functionECute = functionECute;
	this.component = 'button';

	this.setType = function(type){
		this.type = type;
	}

	this.setLabel = function(label){
		this.label = label;
	}

	this.setIcon = function(icon){
		this.icon = icon;
	}

	this.setClass = function(_class){
		this._class = _class;
	}

	this.setSize = function(size){
		this.size = size;
	}

	this.setFunctionECute = function(functionECute){
		this.functionECute = functionECute;
	}

	this.setComponent = function(component){
		this.component = component;
	}
}

function ActionEdit(label, _class, size){
	Action.call(this, 'light', label, 'fa fa-edit', _class, size, 'openUpdateModal($(this).parent().parent());');
}
function ActionDelete(label, _class, size){
	Action.call(this, 'danger', label, 'fa fa-close', _class, size, 'deleteElement($(this).parent().parent());');
}

function ActionDeleteModal(){
	Action.call(this, 'danger', '', 'fa fa-close', '', 'btn-sm', 'removeFromTable($(this).parent().parent());');
}