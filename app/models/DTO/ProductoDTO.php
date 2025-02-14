<?php

class ProductoDTO implements JsonSerializable
{
    private $id_producto;
    private $nombre;
    private $descripcion;
    private $precio;
    private $stock;

    public function __construct($id_producto, $nombre, $descripcion, $precio, $stock)
    {
        $this->id_producto = $id_producto;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    public function getIdProducto()
    {
        return $this->id_producto;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getDescripcion()
    {
        return $this->descripcion;
    }

    public function getPrecio()
    {
        return $this->precio;
    }

    public function getStock()
    {
        return $this->stock;
    }
}

?>
