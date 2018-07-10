var isCollapseUp = false;

function CatalogosController(){
	this.createOrUpdateElement = function(){
		var element;
		if($('#row-index').val() != null && $('#row-index').val() != ''){
			element = CatalogosView.elements[parseInt($('#row-index').val())];	
		}else{
			element = new CatalogElement(null, $('#element-descripcion').val(), null);
		}
		
		element.method = 'createOrUpdateElement';
		element.descripcion = $('#element-descripcion').val();

		$.ajax({
			type:'POST',
			url: CatalogosView.rootURL,
			data: element,
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					if(responce.success){
						CatalogosView.getCatalogosGrid({method:'getElementsGrid'});
						$('#update-element-modal').modal('hide');
					}
					alert(responce.message);
				}catch(err){
					alert("Ha ocurrido un error en el servidor");
					return;
				}		
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				console.log("Error contactando con el servidor");
			}
		});

		element.method = undefined;
	};

	this.deleteElement = function(row){
		var elementDelete = colores[row.index()];
		elementDelete.method = 'deleteElement';
		$.ajax({
			type:'POST',
			url: CatalogosView.rootURL,
			data: elementDelete,
			success: function(data){
				try{
					var responce = jQuery.parseJSON(data);
					if(responce.success){
						CatalogosView.getCatalogosGrid({method:'getElementsGrid'});
						alert(responce.message);
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
		elementDelete.method = undefined;
	};

	this.openUpdateModal = function(row){
		if(row != undefined){
			var elementUpdate = CatalogosView.elements[row.index()];
			$('#element-descripcion').val(elementUpdate.descripcion);
			$('#row-index').val(row.index());
		}
		$('#update-element-modal').modal('show');
	};

	this.cleanForm = function(){
		$('#element-descripcion').val('');
		$('#row-index').val('');
		$('#update-element-modal').modal('hide');
	};

	this.searchElement = function(){
		var element = new CatalogElement(
			$('#id-catalogo').val(),
			$('#descripcion').val(),
			null
		);
		CatalogosView.getCatalogosGrid({method:'getElementsGrid', filters: element});
	};

	this.toggleCollapse = function(element){
		if(isCollapseUp){
			element.children().removeClass('fa fa-caret-square-o-down');
			element.children().addClass('fa fa-caret-square-o-up');
			isCollapseUp = false;
		}else{
			element.children().removeClass('fa fa-caret-square-o-up');
			element.children().addClass('fa fa-caret-square-o-down');
			isCollapseUp = true;
		}
	};
}