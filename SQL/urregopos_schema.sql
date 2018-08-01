DROP DATABASE IF EXISTS urrego_pos; 

CREATE DATABASE urrego_pos;

USE urrego_pos;

CREATE TABLE usuarios (
	id 			int(11) AUTO_INCREMENT PRIMARY KEY,
	nombre 		text NOT NULL,
	usuario 	text NOT NULL,
	pass 		text NOT NULL,
	perfil  	text NOT NULL,
	foto    	text NOT NULL,
	estado  	int(11) NOT NULL,
	ultimo_login datetime NOT NULL,
	fecha 		timestamp NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

INSERT INTO usuarios (id, nombre, usuario, pass, perfil, foto, estado, ultimo_login, fecha) VALUES
(1, 'Administrador General', 'admin', 'admin123', 'Administrador', '', 1, '0000-00-00 00:00:00', '2015-09-11 20:20:09' );


CREATE TABLE categorias (

	id    int(11)  AUTO_INCREMENT PRIMARY KEY,
	categoria text NOT NULL,
	fecha TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp

)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;


INSERT INTO categorias (categoria) VALUES 
('Equipos Electromecánicos'),
('Taladros'),
('Andamios'),
('Generadores de Energía'),
('Equipos para Construcción'); 

/* Tabla de Ventas */ 

DROP TABLE ventas;

CREATE TABLE ventas (

	id    		int(11)  AUTO_INCREMENT PRIMARY KEY,
	codigo 	    int NOT NULL,
	id_cliente  int NOT NULL,
	id_vendedor int NOT NULL,
	productos   text NOT NULL,
	impuesto    float,
	neto        float,
	total_venta float,
	metodo_pago text,
	fecha TIMESTAMP NOT NULL DEFAULT current_timestamp ON UPDATE current_timestamp,
	CONSTRAINT fk_ventas_cliente FOREIGN KEY (id_cliente) REFERENCES clientes (id),
	CONSTRAINT fk_ventas_vendedor FOREIGN KEY (id_vendedor) REFERENCES usuarios (id)
)ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

ALTER TABLE `productos`
  ADD CONSTRAINT `fk_productos_categoria` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id`); 

