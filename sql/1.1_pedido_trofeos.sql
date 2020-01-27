CREATE TABLE `trofeoslobo`.`Pedido_Trofeos`(
    `id_pedido` INT UNSIGNED NOT NULL,
    `id_trofeo` INT NOT NULL,
    PRIMARY KEY(`id_pedido`, `id_trofeo`),
    FOREIGN KEY (`id_pedido`) REFERENCES `Pedido`(`id`),
    FOREIGN KEY (`id_trofeo`) REFERENCES `trofeos`(`id`)
);