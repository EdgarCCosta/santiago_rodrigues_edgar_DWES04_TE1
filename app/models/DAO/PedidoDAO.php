<?php

require_once '../app/core/DatabaseSingleton.php';
require_once '../app/models/DTO/PedidoDTO.php';

class PedidoDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DatabaseSingleton::getInstance();
    }

    public function obtenerPedidos()
    {
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM pedidos";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $pedidosDTO = [];
        foreach ($result as $fila) {
            $pedidosDTO[] = new PedidoDTO(
                $fila['id'],
                $fila['usuario_id'],
                $fila['producto_id'],
                $fila['cantidad'],
                $fila['fecha_pedido'],
                $fila['total']
            );
        }
        return $pedidosDTO;
    }

    public function obtenerPedidoByID($id)    {
        $connection = $this->db->getConnection();

        $query = "SELECT * FROM pedidos WHERE id = ?";
        $statement = $connection->prepare($query);
        $statement->execute([$id]);
        $fila = $statement->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
                return new PedidoDTO(
                $fila['id'],
                $fila['usuario_id'],
                $fila['producto_id'],
                $fila['cantidad'],
                $fila['fecha_pedido'],
                $fila['total']
            );
        }
    }

    public function crearPedido($usuario_id, $producto_id, $cantidad, $total)
    {
        $connection = $this->db->getConnection();

        $usuarioDAO = new UsuarioDAO();
        $usuario = $usuarioDAO->obtenerUsuarioByID($usuario_id);
        if (!$usuario) {
            throw new Exception("El usuario con ID $usuario_id no existe.");
        }
    
        $productoDAO = new ProductoDAO();
        $producto = $productoDAO->obtenerProductoByID($producto_id);
        if (!$producto) {
            throw new Exception("El producto con ID $producto_id no existe.");
        }
    
        $query = "INSERT INTO pedidos (usuario_id, producto_id, cantidad, fecha_pedido, total) VALUES (?, ?, ?, NOW(), ?)";
        $statement = $connection->prepare($query);
        $statement->execute([$usuario_id, $producto_id, $cantidad, $total]);
    
        return $this->obtenerPedidoByID($connection->lastInsertId());
    }

    public function actualizarPedido($id, $usuario_id, $producto_id, $cantidad, $total)
{
    $connection = $this->db->getConnection();

    // Verificar si el usuario existe
    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->obtenerUsuarioByID($usuario_id);
    if (!$usuario) {
        throw new Exception("El usuario con ID $usuario_id no existe.");
    }

    // Verificar si el producto existe
    $productoDAO = new ProductoDAO();
    $producto = $productoDAO->obtenerProductoByID($producto_id);
    if (!$producto) {
        throw new Exception("El producto con ID $producto_id no existe.");
    }

    // Actualizar el pedido
    $query = "UPDATE pedidos SET usuario_id = ?, producto_id = ?, cantidad = ?, total = ? WHERE id = ?";
    $statement = $connection->prepare($query);
    $statement->execute([$usuario_id, $producto_id, $cantidad, $total, $id]);

    return $this->obtenerPedidoByID($id);
}

    public function eliminarPedido($id)    {
        $connection = $this->db->getConnection();

        $query = "DELETE FROM pedidos WHERE id = ?";
        $statement = $connection->prepare($query);
        
        return $statement->execute([$id]);
    }
}

?>
