DROP DATABASE IF EXISTS trofeoslobo;
create database if not exists trofeoslobo;

use trofeoslobo;

create table if not exists categorias(
	id integer auto_increment,
	descripcion varchar(500),
	estatus boolean default 1,
	primary key(id)
);

create table if not exists colores(
	id integer auto_increment,
	descripcion varchar(500),
	estatus boolean default 1,
	primary key(id)
);

create table if not exists materiales(
	id integer auto_increment,
	descripcion varchar(500),
	estatus boolean default 1,
	primary key(id)
);

create table if not exists tiposMedidas(
	id integer auto_increment,
	descripcion varchar(500),
	estatus boolean default 1,
	primary key(id)
);

create table if not exists usuarios(
	id integer auto_increment,
	usuario varchar(250),
	passwd varchar(2500),
	email varchar(500),
	estatus boolean default 1,
	primary key(id)
);

create table if not exists trofeos(
	id integer auto_increment,
	nombre varchar(500),
	descripcion varchar(2500),
	precio double,
	fotoPath varchar(500),
	estatus boolean default 1,
	primary key(id)
);

create table if not exists elementos(
	id integer auto_increment,
	nombre varchar(500),
	descripcion varchar(2500),
	precio double,
	idColor integer,
	idCategoria integer,
	idMaterial integer,
	estatus boolean default 1,
	primary key(id),
	foreign key (idColor) references colores(id),
	foreign key (idCategoria) references categorias(id),
	foreign key (idMaterial) references materiales(id)
);

create table if not exists medidas(
	id integer auto_increment,
	idTipoMedida integer,
	medida double,
	idElemento integer,
	estatus boolean default 1,
	primary key(id),
	foreign key (idTipoMedida) references tiposMedidas(id),
	foreign key (idElemento) references elementos(id)
);

create table if not exists TrofeosElementos(
	id integer auto_increment,
	idTrofeo integer,
	idElemento integer,
	primary key(id),
	foreign key (idTrofeo) references trofeos(id),
	foreign key (idElemento) references elementos(id)
);

create TABLE if not exists vistas(
	id int AUTO_INCREMENT,
    descripcion varchar(255),
    estatus boolean DEFAULT 1,
    `isDropDown` bit(1) DEFAULT 0,
    `subMenus` varchar(1000) DEFAULT NULL,
    PRIMARY KEY (id)
);