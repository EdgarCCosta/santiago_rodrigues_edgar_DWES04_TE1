CREATE DATABASE santiago_rodrigues_edgar_DWES04;

USE santiago_rodrigues_edgar_DWES04;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(50) UNIQUE NOT NULL,
    telefono VARCHAR(15) NOT NULL,
    fecha_registro DATE DEFAULT CURRENT_DATE
);

-- Tabla de productos
CREATE TABLE productos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100) NOT NULL,
    descripcion VARCHAR(255), -- Campo de descripción del producto
    precio DECIMAL(10, 2) NOT NULL CHECK (precio >= 0),
    stock INT NOT NULL DEFAULT 0 CHECK (stock >= 0)
);

-- Tabla de pedidos (relación entre usuarios y productos)
CREATE TABLE pedidos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    producto_id INT NOT NULL,
    cantidad INT NOT NULL CHECK (cantidad > 0),
    fecha_pedido DATE DEFAULT CURRENT_DATE,
    total DECIMAL(10, 2) NOT NULL CHECK (total >= 0),
    FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
    FOREIGN KEY (producto_id) REFERENCES productos (id) ON DELETE CASCADE
);

INSERT INTO usuarios (nombre, apellido, email, telefono) VALUES
('Juan', 'Pérez', 'juan.perez@email.com', '1234567890'),
('Ana', 'Gómez', 'ana.gomez@email.com', '0987654321'),
('Carlos', 'Martínez', 'carlos.martinez@email.com', '1122334455'),
('Lucía', 'Rodríguez', 'lucia.rodriguez@email.com', '5566778899'),
('Pedro', 'López', 'pedro.lopez@email.com', '6677889900'),
('Marta', 'Sánchez', 'marta.sanchez@email.com', '7788990011'),
('José', 'Ramírez', 'jose.ramirez@email.com', '8899001122'),
('María', 'Fernández', 'maria.fernandez@email.com', '9900112233'),
('Laura', 'García', 'laura.garcia@email.com', '1010101010'),
('David', 'Vázquez', 'david.vazquez@email.com', '2020202020');


-- Insertar productos electrónicos
-- Insertar productos electrónicos
INSERT INTO productos(nombre, descripcion, precio, stock)VALUES 
('Smartphone XYZ', 'Smartphone con pantalla de 6.5 pulgadas, cámara de 12 MP, batería de 4000 mAh', 299.99, 50),
('Laptop ABC', 'Laptop de 15.6 pulgadas, procesador i7, 16GB de RAM', 999.99,  30),
('Auriculares Bluetooth', 'Auriculares inalámbricos con cancelación de ruido', 79.99, 100),
('Tablet 10"', 'Tablet con pantalla de 10 pulgadas y 64GB de almacenamiento', 199.99, 75),
('Smartwatch XYZ', 'Reloj inteligente con seguimiento de salud y notificaciones', 149.99, 150),
('Cámara Digital', 'Cámara de fotos con lente 18-55mm y resolución 24MP', 399.99, 40),
('TV 4K 55"', 'Televisor 4K de 55 pulgadas con tecnología HDR', 599.99, 60),
('Altavoces Bluetooth', 'Altavoces inalámbricos con calidad de sonido superior', 89.99, 120),
('Consola de Videojuegos', 'Consola de videojuegos de última generación con dos mandos', 499.99, 25),
('Proyector LED', 'Proyector LED portátil con resolución 1080p', 249.99, 15);

-- Insertar pedidos
INSERT INTO pedidos (usuario_id, producto_id, cantidad, total)VALUES 
(1, 1, 2, 599.98), -- Usuario Juan Perez compra 2 Smartphones XYZ
(2, 5, 1, 149.99), -- Usuario Ana Gomez compra 1 Smartwatch XYZ
(3, 3, 3, 239.97), -- Usuario Carlos Martinez compra 3 Auriculares Bluetooth
(4, 4, 1, 199.99), -- Usuario 4 compra 1 Tablet 10"
(5, 7, 1, 599.99), -- Usuario 5 compra 1 TV 4K 55"
(6, 2, 1, 999.99), -- Usuario 6 compra 1 Laptop ABC
(7, 6, 1, 399.99), -- Usuario 7 compra 1 Cámara Digital
(8, 8, 2, 179.98), -- Usuario 8 compra 2 Altavoces Bluetooth
(9, 9, 1, 499.99), -- Usuario 9 compra 1 Consola de Videojuegos
(10, 10, 1, 249.99);
