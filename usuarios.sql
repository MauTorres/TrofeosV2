INSERT INTO `vistas` VALUES
(null, 'main', 1),
(null, 'usuarios', 1),
(null, 'trofeos', 1),
(null, 'materiales', 1);

INSERT INTO `usuarios`(`usuario`, `passwd`, `email`)
VALUES('mcsonk', '1234', 'misaelarturo@gmail.com');

INSERT INTO `colores`(`descripcion`)
VALUES('Rojo'), ('Azul'), ('Verde');

INSERT INTO `materiales`(`descripcion`)
VALUES('Madera'), ('Oro'), ('Cobre');

INSERT INTO `categorias`(`descripcion`)
VALUES('Natacion'), ('Box'), ('Futbol');

INSERT INTO `elementos`(`nombre`, `descripcion`, `precio`, `idColor`, `idDeporte`, `idMaterial`)
VALUES('Elemento 1', 'Es el primero', '500', 1, 1, 1);
