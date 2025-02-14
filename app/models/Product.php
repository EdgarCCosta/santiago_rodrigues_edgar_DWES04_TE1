<?php

class Product
{
    public $id;
    public $nombre;
    public $precio;
    public $stock;
    public $descripcion;

    public function __construct($id, $nombre, $precio, $stock, $descripcion)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->descripcion = $descripcion;
    }
}
?>