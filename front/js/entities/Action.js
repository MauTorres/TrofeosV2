function Action(type, label, icon, _class, size, functionECute){
	this.type = type;
	this.label = label;
	this.icon = icon;
	this._class = _class;
	this.size = size;
	this.functionECute = functionECute;
}

function ActionEdit(label, _class, size){
	Action.call(this, 'light', label, 'fa fa-edit', _class, size, 'openUpdateModal($(this).parent().parent());');
}
function ActionDelete(label, _class, size){
	Action.call(this, 'danger', label, 'fa fa-close', _class, size, 'deleteElement($(this).parent().parent());');	
}