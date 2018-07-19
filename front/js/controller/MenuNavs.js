MenuNavs = {
	setSubMenusNavs: function(dropDownNav, submenus){
		if(submenus == null)
			return;
		var menus = submenus.submenus;
		var menusAria = $('<div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink"></div>');
		
		for(var subCount = 0; subCount < menus.length; subCount++){
			menusAria.append('<a class="dropdown-item" href="' + menus[subCount] + '.html">' + menus[subCount] + '</a>');
		}
		dropDownNav.append(menusAria);
	},
	setMenuNavs: function (navsNameArray, currentPage, userName){
		var navVar = $(".navbar-nav");
		var navItem;
		for(var navsCount = 0; navsCount < navsNameArray.length; navsCount ++){
			navItem = navsNameArray[navsCount];

			var active = '';
			if(navItem.descripcion == currentPage)
				active = 'active';

			var subMenus = null;
			var dropDown = '';
			var aLink = '<a class="nav-link" href="' + navItem.descripcion + '.html">' + navItem.descripcion + '</a>';
			if(navItem.isDropDown=="1"){
				dropDown = 'dropdown';
				aLink = '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' + navItem.descripcion + '</a>';
				subMenus = jQuery.parseJSON(navItem.subMenus);
			}
			var liNav = $('<li class="nav-item ' + active + ' ' + dropDown + '"></li>');
			liNav.append(aLink);
			MenuNavs.setSubMenusNavs(liNav, subMenus);
			navVar.append(liNav);
		}
		$('#main-nav').append(
			'<span class="navbar-text">' +
				'<span class="fa fa-user-o"></span>' +
				userName + '&nbsp;&nbsp;' +
				'<button type="button" class="btn btn-danger" onclick="SessionController.endSession();"><span class="fa fa-sign-out" aria-hidden="true"></span></button>' +
			'</span>'
		);
	},
	getMenuNavs: function (currentPage, userName){
		$.ajax({
			type:'GET',
			url: '../../src/controller/VistasController.php',
			data: {method: 'getVistasAll'},
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					if(responce.success){
						MenuNavs.setMenuNavs(responce.data, currentPage, userName);
					}else{
						alert("Ha ocurrido un error en el servidor");
						return;
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
	}
};