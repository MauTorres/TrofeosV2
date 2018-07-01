<?php
require_once dirname(dirname(__DIR__))."/src/utils/Constants.php";
session_start();
if (session_status() == PHP_SESSION_NONE){
	header( "Location: ../../".LOGIN_PAGE);
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Loggin</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="../js/controller/Usuario.js"></script>
	<script src="../js/controller/ActionButton.js"></script>
	<script src="../js/controller/TableCreator.js"></script>
	<script src="../js/controller/MenuNavs.js"></script>
	<script src="../js/controller/usuariosController.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/main.css">
	<link rel="stylesheet" href="../css/usuarios.css">
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<a class="navbar-brand" href="#">Trofeos Lobo</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavAltMarkup">
			<div class="navbar-nav">
			</div>
		</div>
	</nav>
	<div class="container">
		<div class="row">
			<div class="col-sm-8">
				<h2>Usuarios</h2>
			</div>
			<div class="col-sm-4">
				<button type="button" class="btn btn-success" onclick="openUpdateModal(null)"><span class="fa fa-user-plus" aria-hidden="true"></span></button>
				<button class="btn btn-secondary" id="btn-collapse-search" type="button" data-toggle="collapse" data-target="#search-collapse" aria-expanded="true" aria-controls="search-collapse" onclick="toggleCollapse($(this));">
					<span class="fa fa-caret-square-o-down" aria-hidden="true"></span>
				</button>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12 accordion" id="search-user">
				<div class="card">
					<div id="search-collapse" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<form id="form-search-user">
								<div class="row">
									<div class="col">
										<input type="text" id="id-usuario" class="form-control" placeholder="ID usuario">
									</div>
									<div class="col">
										<input type="text" id="nombre-usuario" class="form-control" placeholder="Nombre de usuario">
									</div>
									<div class="col">
										<input type="text" id="mail-usuario" class="form-control" placeholder="e-mail">
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
									</div>
									<div class="col-sm-4">
									</div>
									<div class="col-sm-4">
										<button class="btn btn-dark search-btn" type="button" id="btn-search-user" onclick="searchUser();">
											Buscar
										</button>
									</div>	
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>		
		</div>
		<div class="row">
			<table class="table table-striped table-hover" id="user-table">
			</table>
		</div>
	</div>
	<div class="modal fade" id="update-user-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Usuario</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<form id="form-update-user">
						<div class="form-group">
							<label for="usuario">Nombre de usuario</label>
							<input type="text" class="form-control" id="usuario" placeholder="Nombre de usuario">
							<label for="email">Email</label>
							<input type="email" class="form-control" id="email" placeholder="email">
							<label for="passwd">Contraseña</label>
							<input type="password" class="form-control" id="passwd" placeholder="Contraseña">
							<label for="passwdValidate">Valide la contraseña</label>
							<input type="password" class="form-control" id="passwdValidate" placeholder="Valide la contraseña">
							<input type="hidden" class="form-control" id="row-index">
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" onclick="cleanUserForm();" id="btn-update-user-cancel">Cerrar</button>
					<button type="button" class="btn btn-primary" onclick="createOrUpdateUser();" id="btn-update-user">Guardar</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>