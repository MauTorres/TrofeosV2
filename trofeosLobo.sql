create database if not exists trofeoslobo;

use trofeoslobo;

create table if not exists deportes(
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
	idDeporte integer,
	idMaterial integer,
	estatus boolean default 1,
	primary key(id),
	foreign key (idColor) references colores(id),
	foreign key (idDeporte) references deportes(id),
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
    estatus boolean,
    PRIMARY KEY (id)
);

insert into vistas
values
(null, 'main', 1),
(null, 'usuarios', 1),
(null, 'trofeos', 1),
(null, 'materiales', 1);