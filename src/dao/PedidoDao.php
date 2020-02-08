<?php
/**
* 
*/
require_once __DIR__."/DAO.php";
require_once __DIR__."/ClienteDao.php";
require_once __DIR__."/entities/Cliente.php";
require_once __DIR__."/entities/Pedido.php";
require_once __DIR__."/entities/Usuario.php";
require_once dirname(__DIR__)."/utils/Loger.php";

class PedidoDao extends DAO
{
    private $clienteDao;
    private $usuarioDao;

    function __construct()
    {
        parent::__construct();
        $this->clienteDao = new ClienteDao();
        $this->usuarioDao = new UsuarioDao();
    }

    public function getElementByElementFolio($ElementFolio){
        $pedidos = array();
        $result = $this->query("SELECT * FROM Pedidos WHERE Folio = ?", array($ElementFolio));
        $result = $result->getResultSet();

        foreach ($result as $pedido) {
            array_push($pedidos, new Pedido($pedido));
        }

        return $pedidos;
    }

    public function saveElement($pedido){
        $query = "INSERT INTO Pedido(folio, fecha_elaboracion, fecha_entrega, subtotal, total, cliente, id_usuario)
            VALUES(:folio, :fecha_elaboracion, :fecha_entrega, :subtotal, :total, :cliente,
            (SELECT id FROM usuarios WHERE usuario = :id_usuario) )";
        $values = array(
            ":folio"=>$pedido->folio,
            ":fecha_elaboracion"=>$pedido->fElaboracion,
            ":fecha_entrega"=>$pedido->fEntrega,
            ":subtotal"=>$pedido->subtotal,
            ":total"=>$pedido->total,
            ":cliente"=>$pedido->idCliente,
            ":id_usuario"=>$pedido->IdUsuario
        );
        return $this->execute($query, $values);
    }

    public function getElementsGrid($params){
        $query = sprintf("
            SELECT 
                P.id,
                   P.Folio,
                P.fElaboracion,
                P.fEntrega,
                P.subtotal,
                   P.total,
                IF(Cl.nombre is null, '', Cl.nombre) AS cliente,
                IF(U.usuario is null, '', U.usuario) AS usuario,
            FROM Pedidos P
            LEFT JOIN Clientes Cl
                ON P.idCliente = Cl.id
            LEFT JOIN usuarios U
                ON P.IdUsuario = U.id
            WHERE 
                P.estatus = 1
                %s", $params);
        
        return $this->query($query, null);
    }

    public function getElementosTrofeos($params){
        //IF(Cl.nombre is null, '', Cl.nombre) AS cliente,
        /*LEFT JOIN Clientes Cl
        ON P.idCliente = Cl.id*/
        $query = sprintf("
SELECT 
    P.id,
    P.folio,
    P.fecha_elaboracion,
    P.fecha_entrega,
    P.subtotal,
    P.total,
    IF(U.usuario is null, '', U.usuario) AS usuario,
    cliente
FROM Pedido P
LEFT JOIN usuarios U
    ON P.id_usuario = U.id
WHERE 
    P.estatus = 1
                %s", $params);

        return $this->query($query, null);
    }

    public function getElementosPedido($pedido){
        $query = sprintf("
            SELECT 
                P.id,
                   P.Folio,
                P.fElaboracion,
                P.fEntrega,
                P.subtotal,
                   P.total,
                IF(Cl.nombre is null, '', Cl.nombre) AS cliente,
                IF(U.usuario is null, '', U.usuario) AS usuario,
            FROM Pedidos P
            LEFT JOIN Clientes Cl
                ON P.idCliente = Cl.id
            LEFT JOIN usuarios U
                ON P.IdUsuario = U.id
            JOIN TrofeosPedidos TP
                ON TP.idPedido = P.id
            WHERE 
                P.estatus = 1
                AND TP.idTrofeo = %s", $trofeo->id);

        return $this->query($query, null);
    }

    public function deleteElement($pedido){
        return $this->execute("UPDATE Pedido SET estatus = 0 WHERE id = :id", array(":id"=>$pedido->id));
    }

    public function getElementByID($pedido){
        $result = $this->query("SELECT * FROM Pedidos WHERE id = ?", array($pedido->id));
        $row = $result->getResultSet()[0];
        if ($row == null) {
            return null;
        }
        $cliente = $this->clienteDao->getUserByBussinessName( new Cliente($row['idCliente'], NULL) );
        $usuario = $this->usuarioDao->getUserByUserName( new Usuario($row['IdUsuario'], NULL ));
        return new Pedido($row);
    }

    public function createOrUpdateElement($pedido){
        $query = "UPDATE Pedido SET fecha_creacion = NOW()";
        $values = array();
        if(!empty($pedido->folio)){
            $query = $query.", folio = :folio";
            $values[':folio'] = $pedido->folio;
        }

        if(!empty($pedido->fElaboracion)){
            $query = $query.", fecha_elaboracion = :fecha_elaboracion";
            $values[':fecha_elaboracion'] = $pedido->fElaboracion;
        }

        if(!empty($pedido->fEntrega)){
            $query = $query.", fecha_entrega = :fecha_entrega";
            $values[':fecha_entrega'] = $pedido->fEntrega;
        }

        if(!empty($pedido->subtotal)){
            $query = $query.", subtotal = :subtotal";
            $values[':subtotal'] = $pedido->subtotal;
        }

        if(!empty($pedido->total)){
            $query = $query.", total = :total";
            $values[':total'] = $pedido->total;
        }

        if(!empty($pedido->idCliente)){
            $query = $query.", cliente = :cliente";
            $values[':cliente'] = $pedido->idCliente;
        }

        if(!empty($pedido->IdUsuario)){
            $query = $query.", id_usuario = (SELECT id FROM usuarios WHERE usuario = :id_usuario)";
            $values[':id_usuario'] = $pedido->IdUsuario;
        }

        if(!empty($pedido->estatus)){
            $query = $query.", estatus = :estatus";
            $values[':estatus'] = $pedido->IdUsuario;
        }

        $query = $query." WHERE id = :id";
        $values[":id"] = $pedido->id;

        return $this->execute($query, $values);
    }
}
?>
