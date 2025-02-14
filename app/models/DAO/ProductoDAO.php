<?php

require_once '../app/core/DatabaseSingleton.php';
require_once '../app/models/DTO/ProductoDTO.php';

class ProductoDAO
{
    private $db;

    public function __construct()
    {
        $this->db = DatabaseSingleton::getInstance();
    }

    public function obtenerProductos()
    {
        $connection = $this->db->getConnection();
        $query = "SELECT * FROM productos";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $productosDTO = [];
        foreach ($result as $fila) {
            $productosDTO[] = new ProductoDTO(
                $fila['id'],
                $fila['nombre'],
                $fila['descripcion'],
                $fila['precio'],
                $fila['stock']
            );
        }
        return $productosDTO;
    }

    public function obtenerProductoByID($id)
{
    $connection = $this->db->getConnection();
    $query = "SELECT * FROM productos WHERE id = ?";
    $statement = $connection->prepare($query);
    $statement->execute([$id]);
    $fila = $statement->fetch(PDO::FETCH_ASSOC);

    if ($fila) {
        return new ProductoDTO(
            $fila['id'],
            $fila['nombre'],
            $fila['descripcion'],
            $fila['precio'],
            $fila['stock']
        );
    }
    return null;
}

    public function crearProducto($nombre, $descripcion, $precio, $stock)
    {
        $connection = $this->db->getConnection();
        $query = "INSERT INTO productos (nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?)";
        $statement = $connection->prepare($query);
        $statement->execute([$nombre, $descripcion, $precio, $stock]);

        return $this->obtenerProductoByID($connection->lastInsertId());
    }

    public function actualizarProducto($id, $nombre, $descripcion, $precio, $stock)
    {
        $connection = $this->db->getConnection();
        $query = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ? WHERE id = ?";
        $statement = $connection->prepare($query);
        $statement->execute([$nombre, $descripcion, $precio, $stock, $id]);

        return $this->obtenerProductoByID($id);
    }

    public function eliminarProducto($id)
    {
        $connection = $this->db->getConnection();
        $query = "DELETE FROM productos WHERE id = ?";
        $statement = $connection->prepare($query);
        return $statement->execute([$id]);
    }
}

?>
