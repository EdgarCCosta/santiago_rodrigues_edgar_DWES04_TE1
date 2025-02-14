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
    public function crearPedido()
    {
        $data = json_decode(file_get_contents('php://input'), true);

            $nuevoPedido = $this->pedidoDAO->crearPedido(
                $data['usuario_id'],
                $data['producto_id'],
                $data['cantidad'],
                $data['total'],
            );
            echo json_encode($nuevoPedido);
    }

    // Actualizar un pedido existente
    public function actualizarPedido($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $pedidoActualizado = $this->pedidoDAO->actualizarPedido(
            $id,
            $data['usuario_id'],
            $data['producto_id'],
            $data['cantidad'],
            $data['total'],
        );
            echo json_encode($pedidoActualizado);
    }

    // Eliminar un pedido
    public function eliminarPedido($id)
    {
        $pedido = $this->pedidoDAO->obtenerPedidoByID($id);
        if ($pedido) {
            $eliminado = $this->pedidoDAO->eliminarPedido($id);
            echo json_encode(['eliminado' => $eliminado]);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'Pedido no encontrado']);
        }
    }
}

?>