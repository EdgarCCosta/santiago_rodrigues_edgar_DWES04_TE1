<?php

require_once '../app/models/DAO/PedidoDAO.php';

class PedidoController
{
    private $pedidoDAO;

    public function __construct()
    {
        $this->pedidoDAO = new PedidoDAO();
    }

    // Obtener todos los pedidos
    public function obtenerPedidos()
    {
        $pedidos = $this->pedidoDAO->obtenerPedidos();
        echo json_encode($pedidos);
    }

    // Obtener un pedido por ID
    public function obtenerPedidoByID($id)
    {
        $pedido = $this->pedidoDAO->obtenerPedidoByID($id);
        if ($pedido) {
            echo json_encode($pedido);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    }

    // Crear un nuevo pedido
    public function crearPedido($usuario_id, $producto_id, $cantidad, $total)
    {
        try {
            $nuevoPedido = $this->pedidoDAO->crearPedido($usuario_id, $producto_id, $cantidad, $total);
            echo json_encode($nuevoPedido);
        } catch (Exception $e) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Actualizar un pedido existente
    public function actualizarPedido($id, $usuario_id, $producto_id, $cantidad, $total)
    {
        try {
            $pedidoActualizado = $this->pedidoDAO->actualizarPedido($id, $usuario_id, $producto_id, $cantidad, $total);
            echo json_encode($pedidoActualizado);
        } catch (Exception $e) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    // Eliminar un pedido
    public function eliminarPedido($id)
    {
        try {
            $eliminado = $this->pedidoDAO->eliminarPedido($id);
            echo json_encode(['eliminado' => $eliminado]);
        } catch (Exception $e) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}

?>