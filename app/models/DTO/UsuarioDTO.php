<?php

class UsuarioDTO implements JsonSerializable {
    private $id;
    private $nombre;
    private $apellido;
    private $email;
    private $telefono;
    private $fechaRegistro;

    public function __construct($id, $nombre, $apellido, $email, $telefono, $fechaRegistro) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = $email;
        $this->telefono = $telefono;
        $this->fechaRegistro = $fechaRegistro;
    }

    public function jsonSerialize(): mixed {
        return get_object_vars($this);
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Get the value of apellido
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Get the value of email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the value of telefono
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Get the value of fechaRegistro
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

}
?>
