function ActionButton(type, label, icon, _class, size){
	this.icon = '<span class="' + icon + '" aria-hidden="true"></span>';
	var btnClass = '';
	if(_class != undefined && _class != '')
		btnClass = ' ' + _class; 
	this.mold = '<button type="button" class="btn ' + size + ' btn-' + type + btnClass + '">' + this.icon + label + '</button>';
} 