CREATE TABLE Pedido(
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    folio VARCHAR(20) NOT NULL,
    fecha_elaboracion DATE NOT NULL,
    fecha_entrega DATE NOT NULL,
    subtotal DECIMAL NULL,
    total DECIMAL NULL,
    cliente VARCHAR(30) NOT NULL,
    id_usuario INTEGER NOT NULL,
    estatus BIT NOT NULL DEFAULT 1,
    PRIMARY KEY (id),
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id)
);