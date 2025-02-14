<?php

require __DIR__ . '/../models/DAO/UsuarioDAO.php';

class UsuarioController
{
    private $usuarioDAO;

    public function __construct()
    {
        $this->usuarioDAO = new UsuarioDAO();
    }

    // Obtener todos los usuarios
    public function obtenerUsuarios()
    {
        $usuarios = $this->usuarioDAO->obtenerUsuarios();
        echo json_encode($usuarios);
    }

    // Obtener un usuario por ID
    public function obtenerUsuarioByID($id)
    {
        $usuario = $this->usuarioDAO->obtenerUsuarioByID($id);
        if ($usuario) {
            echo json_encode($usuario);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    }

    // Crear un nuevo usuario
    public function crearUsuario()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $nuevoUsuario = $this->usuarioDAO->crearUsuario(
            $data['nombre'],
            $data['apellido'],
            $data['email'],
            $data['telefono']
        );
        echo json_encode($nuevoUsuario);
    }

    // Actualizar un usuario existente
    public function actualizarUsuario($id)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $usuarioActualizado = $this->usuarioDAO->actualizarUsuario(
            $id,
            $data['nombre'],
            $data['apellido'],
            $data['email'],
            $data['telefono']
        );
        echo json_encode($usuarioActualizado);
    }

    // Eliminar un usuario
    public function eliminarUsuario($id)
    {
        $usuario = $this->usuarioDAO->obtenerUsuarioByID($id);
        if ($usuario) {
            $eliminado = $this->usuarioDAO->eliminarUsuario($id);
            echo json_encode(['eliminado' => $eliminado]);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'Usuario no encontrado']);
        }
    }
}

?>