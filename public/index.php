<?php

require_once '../app/core/Router.php';
require_once '../app/controllers/PedidoController.php';
require_once '../app/controllers/ProductoController.php';
require_once '../app/controllers/UsuarioController.php';

// Crear una instancia del Router
$router = new Router();

// Definir rutas
$router->add('GET', '/DWES/v2/public/pedidos', 'PedidoController', 'obtenerPedidos');
$router->add('GET', '/DWES/v2/public/pedidos/{id}', 'PedidoController', 'obtenerPedidoByID');
$router->add('POST', '/DWES/v2/public/pedidos', 'PedidoController', 'crearPedido');
$router->add('PUT', '/DWES/v2/public/pedidos/{id}', 'PedidoController', 'actualizarPedido');
$router->add('DELETE', '/DWES/v2/public/pedidos/{id}', 'PedidoController', 'eliminarPedido');

$router->add('GET', '/DWES/v2/public/productos', 'ProductoController', 'obtenerProductos');
$router->add('GET', '/DWES/v2/public/productos/{id}', 'ProductoController', 'obtenerProductoByID');
$router->add('POST', '/DWES/v2/public/productos', 'ProductoController', 'crearProducto');
$router->add('PUT', '/DWES/v2/public/productos/{id}', 'ProductoController', 'actualizarProducto');
$router->add('DELETE', '/DWES/v2/public/productos/{id}', 'ProductoController', 'eliminarProducto');

$router->add('GET', '/DWES/v2/public/usuarios', 'UsuarioController', 'obtenerUsuarios');
$router->add('GET', '/DWES/v2/public/usuarios/{id}', 'UsuarioController', 'obtenerUsuarioByID');
$router->add('POST', '/DWES/v2/public/usuarios', 'UsuarioController', 'crearUsuario');
$router->add('PUT', '/DWES/v2/public/usuarios/{id}', 'UsuarioController', 'actualizarUsuario');
$router->add('DELETE', '/DWES/v2/public/usuarios/{id}', 'UsuarioController', 'eliminarUsuario');

// Obtener la URL y el método HTTP
$url = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

// Eliminar parámetros de la URL (si los hay)
$url = strtok($url, '?');

// Intentar hacer coincidir la ruta
$routeMatch = $router->matchRoutes($url, $method);

if ($routeMatch) {
    $controllerName = $routeMatch['controller'];
    $actionName = $routeMatch['action'];
    $params = $routeMatch['params'];

    // Crear una instancia del controlador
    $controller = new $controllerName();

    try {
        // Validar datos para métodos POST y PUT
        if ($method === 'POST' || $method === 'PUT') {
            $data = json_decode(file_get_contents('php://input'), true);

            // Validar datos según el controlador y la acción
            $validationErrors = $this->validateData($controllerName, $actionName, $data);
            if (!empty($validationErrors)) {
                http_response_code(400); // Bad Request
                echo json_encode(['error' => 'Datos inválidos', 'details' => $validationErrors]);
                return;
            }

            // Agregar los datos validados a los parámetros
            $params['data'] = $data;
        }

        // Llamar al método del controlador con los parámetros
        if (method_exists($controller, $actionName)) {
            call_user_func_array([$controller, $actionName], $params);
        } else {
            http_response_code(404); // Not Found
            echo json_encode(['error' => 'Método no encontrado en el controlador']);
        }
    } catch (PDOException $e) {
        // Manejo de errores de base de datos
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Error de base de datos: ' . $e->getMessage()]);
    } catch (Exception $e) {
        // Manejo de otros errores
        http_response_code(500); // Internal Server Error
        echo json_encode(['error' => 'Error interno del servidor: ' . $e->getMessage()]);
    }
} else {
    http_response_code(404); // Not Found
    echo json_encode(['error' => 'Ruta no encontrada']);
}

// Función para validar datos según el controlador y la acción
function validateData($controllerName, $actionName, $data)
{
    $errors = [];

    switch ($controllerName) {
        case 'PedidoController':
            if ($actionName === 'crearPedido' || $actionName === 'actualizarPedido') {
                if (!isset($data['usuario_id'], $data['producto_id'], $data['cantidad'], $data['total'])) {
                    $errors[] = 'Datos incompletos para el pedido.';
                } elseif (!is_numeric($data['usuario_id']) || !is_numeric($data['producto_id']) || 
                          !is_numeric($data['cantidad']) || !is_numeric($data['total'])) {
                    $errors[] = 'Datos inválidos para el pedido.';
                }
            }
            break;

        case 'ProductoController':
            if ($actionName === 'crearProducto' || $actionName === 'actualizarProducto') {
                if (!isset($data['nombre'], $data['descripcion'], $data['precio'], $data['stock'])) {
                    $errors[] = 'Datos incompletos para el producto.';
                } elseif (!is_string($data['nombre']) || !is_string($data['descripcion']) || 
                          !is_numeric($data['precio']) || !is_numeric($data['stock'])) {
                    $errors[] = 'Datos inválidos para el producto.';
                }
            }
            break;

        case 'UsuarioController':
            if ($actionName === 'crearUsuario' || $actionName === 'actualizarUsuario') {
                if (!isset($data['nombre'], $data['apellido'], $data['email'], $data['telefono'])) {
                    $errors[] = 'Datos incompletos para el usuario.';
                } elseif (!is_string($data['nombre']) || !is_string($data['apellido']) || 
                          !is_string($data['email']) || !is_string($data['telefono'])) {
                    $errors[] = 'Datos inválidos para el usuario.';
                }
            }
            break;
    }

    return $errors;
}

?>