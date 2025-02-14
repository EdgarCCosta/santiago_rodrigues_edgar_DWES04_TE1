<?php

require_once '../app/core/DatabaseSingleton.php';
require_once '../app/models/DTO/UsuarioDTO.php';

class UsuarioDAO {

    private $db;

    public function __construct(){
        $this->db = DatabaseSingleton::getInstance();
    }


   public function obtenerUsuarios() {
        $connection = $this->db->getConnection();

        $query = "SELECT * FROM usuarios";
        $statement = $connection->query($query);
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $usuariosDTO = [];
        foreach ($result as $fila) {
            $usuariosDTO[] = new UsuarioDTO(
                $fila['id'],
                $fila['nombre'],
                $fila['apellido'],
                $fila['email'],
                $fila['telefono'],
                $fila['fecha_registro']
            );
        }
        return $usuariosDTO;
    }


    public function obtenerUsuarioByID($id){
        $connection = $this->db->getConnection();

        $query = "SELECT * FROM usuarios WHERE id = ?";
        $statement = $connection->prepare($query);
        $statement -> execute ([$id]);
        $fila = $statement->fetch(PDO::FETCH_ASSOC);

        if ($fila) {
            return new UsuarioDTO(
                $fila['id'],
                $fila['nombre'],
                $fila['apellido'],
                $fila['email'],
                $fila['telefono'],
                $fila['fecha_registro']
            );
        }
    }


    public function crearUsuario ($nombre, $apellido, $email, $telefono){
        $connection = $this->db->getConnection();

        $query = "INSERT INTO usuarios (nombre, apellido, email, telefono, fecha_registro) VALUES (?, ?, ?, ?, NOW())";
        $statement = $connection->prepare($query);
        $statement->execute([$nombre, $apellido, $email, $telefono]);

        return $this->obtenerUsuarioByID($connection->lastInsertID());
    }

    public function actualizarUsuario ($id, $nombre, $apellido, $email, $telefono){
        $connection = $this->db->getConnection();

        $query = "UPDATE usuarios SET nombre = ?, apellido = ?, email = ?, telefono = ? WHERE id = ?";
        $statement = $connection->prepare($query);
        $statement->execute([$nombre, $apellido, $email, $telefono, $id]);

        return $this->obtenerUsuarioByID($id);
    }

    
    public function eliminarUsuario($id){
        $connection = $this->db->getConnection();

        $query = "DELETE FROM usuarios WHERE id = ?";
        $statement = $connection->prepare($query);
        return $statement->execute([$id]);
    }

}

?>