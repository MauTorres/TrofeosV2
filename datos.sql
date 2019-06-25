use trofeoslobo;

INSERT INTO `categorias` (`descripcion`) VALUES 
('Copa'),
('Figura'),
('Futbol'),
('Basket'),
('Baseball'),
('Cine'),
('Teatro'),
('Tennis'),
('Columna'),
('Piezas de Madera');

INSERT INTO `colores`(`descripcion`) VALUES 
('Cafe Chocolate'),
('Negro'),
('Blanco'),
('Nogal'),
('Verde Marmoleado'),
('Gris Nuevo'),
('Roja'),
('Azul'),
('Cafe Caoba'),
('Oro'),
('Plata'),
('Cobre'),
('Oro Metalico'),
('Turin'),
('Blanco perlado');

INSERT INTO `materiales`(`descripcion`) VALUES 
('Madera'),
('Resina'),
('Vidrio'),
('Metal'),
('Aluminio'),
('Plastico');

INSERT INTO `tiposMedidas`(`descripcion`) VALUES
('15 cm x 8 cm'),
('28 cm x 12 cm');

INSERT INTO `trofeos`(`nombre`, `descripcion`, `precio`, `fotoPath`) VALUES
('TT-01','trofeo tradicional',200,'/img/TT1.jpg'),
('TT-02','trofeo tradicional',150,'/img/TT1.png'),
('Mini Oscar','oscar',250,'/img/Oscar.png'),
('Vince-Lombardi','Trofeo de Futbol Americano',450,'/img/Vince-Lombardi.png'),
('TT-31','trofeo tradicional',180,'/img/TT31.png'),
('TT-25A','Figura 3D con base para cualquier deporte',130,'/img/TT25.png');

INSERT INTO `elementos`( `nombre`, `descripcion`, `precio`, `idColor`, `idCategoria`, `idMaterial`) VALUES 
('Copa Globo Alumino','Copa Globo Aluminio',200,1,3,2),
('Figura','Figura Metalica',200,2,4,3),
('Copa Aro Alumino','Copa Metalica',100,3,5,4),
('Columna Gringa','Columna de Aluminio moldeado',50,4,6,5),
('Figura 3D','Figura de Resina',NULL,5,7,6),
('Madera','Base de madera de 15cm x 8cm',NULL,6,8,1),
('Madera','Base de madera de 28 cm',NULL,7,9,2);

INSERT INTO `vistas`(`descripcion`, `isDropDown`, `subMenus`) VALUES
('main', 0 ,NULL),
('usuarios', 0 ,NULL),
('trofeos', 0 ,NULL),
('elementos', 0 ,NULL),
('catalogos', 1,'{\"submenus\":[\"colores\", \"categorias\", \"materiales\", \"medidas\"]}');

INSERT INTO `usuarios`(`usuario`, `passwd`, `email`) VALUES
('mcsonk', '1234', 'misaelarturo@gmail.com'),
('Mau','Mautor','mail@mail.com'),
('tonatiu',NULL,'yahuitl.trejo@gmail.com'),
('Rafa','rafa','raf@hotmail.com');
