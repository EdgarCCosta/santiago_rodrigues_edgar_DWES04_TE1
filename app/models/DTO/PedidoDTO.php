<?php

class PedidoDTO implements JsonSerializable
{
    private $id_pedido;
    private $id_usuario;
    private $fecha_pedido;
    private $total;

    public function __construct($id_pedido, $id_usuario, $producto_id, $cantidad, $fecha_pedido, $total)
    {
        $this->id_pedido = $id_pedido;
        $this->id_usuario = $id_usuario;
        $this->producto_id = $producto_id;
        $this->cantidad = $cantidad;
        $this->fecha_pedido = $fecha_pedido;
        $this->total = $total;
    }

    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }

    public function getIdPedido()
    {
        return $this->id_pedido;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function getFechaPedido()
    {
        return $this->fecha_pedido;
    }

    public function getTotal()
    {
        return $this->total;
    }
}

?>
