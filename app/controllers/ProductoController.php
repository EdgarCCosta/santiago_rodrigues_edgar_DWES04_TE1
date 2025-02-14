<?php

require_once '../app/models/DAO/ProductoDAO.php';

class ProductoController
{
    private $productoDAO;

    public function __construct()
    {
        $this->productoDAO = new ProductoDAO();
    }

    // Obtener todos los productos
    public function obtenerProductos()
    {
        $productos = $this->productoDAO->obtenerProductos();
        echo json_encode($productos);
    }

    // Obtener un producto por ID
    public function obtenerProducto($id)
    {
        $producto = $this->productoDAO->obtenerProducto($id);
        if ($producto) {
            echo json_encode($producto);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'Producto no encontrado']);
        }
    }

    // Crear un nuevo producto
    public function crearProducto()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $nuevoProducto = $this->productoDAO->crearProducto(
            $data['nombre'],
            $data['descripcion'],
            $data['precio'],
            $data['stock']
        );
        echo json_encode($nuevoProducto);
    }

    // Actualizar un producto existente
    public function actualizarProducto($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $productoActualizado = $this->productoDAO->actualizarProducto(
            $id,
            $data['nombre'],
            $data['descripcion'],
            $data['precio'],
            $data['stock']
        );
        echo json_encode($productoActualizado);
    }

    // Eliminar un producto
    public function eliminarProducto($id)
    {
        $producto = $this->productoDAO->obtenerProductoByID($id);
        if ($producto) {
            $eliminado = $this->productoDAO->eliminarProducto($id);
            echo json_encode(['eliminado' => $eliminado]);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'Producto no encontrado']);
        }
    }
}

?>