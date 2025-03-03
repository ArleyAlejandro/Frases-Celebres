-- Crear la base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS frases_celebres CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE frases_celebres;

-- Tabla de Autores
CREATE TABLE `autor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Tabla de Temas
CREATE TABLE `tema` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Tabla de Frases
CREATE TABLE `frase` (
  `id` int NOT NULL AUTO_INCREMENT,
  `autor_id` int NOT NULL,
  `texto` varchar(400) NOT NULL,
  `tema` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `autor_id` (`autor_id`),
  CONSTRAINT `frase_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
