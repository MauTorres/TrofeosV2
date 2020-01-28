<?php

require_once __DIR__."/DAO.php";
require_once __DIR__."/PedidoDao.php";
require_once __DIR__."/entities/PedidoTrofeos.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class PedidoTrofeosDao extends DAO{
    private $pedidoDao;

    function __construct(){
        parent::__construct();
        $this->pedidoDao = new PedidoDao();
    }

    public function createRelationship($pedido){
        $query = "INSERT INTO `trofeoslobo`.`Pedido_Trofeos`(`id_pedido`, `id_trofeo`)
            VALUES(:id_pedido, :id_trofeo)";
        foreach($pedido->trophies as $val => $trophy){
            $values = array(
                ":id_pedido" => $pedido->id,
                ":id_trofeo" => $trophy
            );
            $this->pedidoDao->execute($query, $values);
        }
    }
}

?>