function ActionCheck(_class, value, functionToExecute){
	var clase = '';
	if(_class != undefined && _class != null && _class != '')
		clase = 'class="' + _class + '"';
	var funct = '';
	if(functionToExecute != undefined && functionToExecute != null && functionToExecute != '')
		funct = '" onClick="' + functionToExecute + '"';
	this.mold = '<input ' + clase + ' type="checkbox" value="' + value + funct + '>';
	this.component = 'check';
}
