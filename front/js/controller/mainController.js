var sessionController = new SessionController();

$(document).ready(function(){
	sessionController.getSession();
	MenuNavs.getMenuNavs('main');
});
