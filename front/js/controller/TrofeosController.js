$(document).ready(function(){
	GridView.rootURL = '../../src/controller/TrofeoController.php';
	SessionController.checkSession('trofeos');
	GridView.getGrid({method: 'getTrofeosGrid'});
});
