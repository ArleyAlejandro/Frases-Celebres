 DROP DATABASE IF EXISTS frases_celebres;

-- Crear la base de datos (si no existe)
CREATE DATABASE IF NOT EXISTS frases_celebres CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE frases_celebres;

-- Crear la tabla 'autor'
CREATE TABLE `autor` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` varchar(255) NOT NULL,
  `url` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ;
ALTER TABLE `autor` AUTO_INCREMENT = 1;
-- Crear la tabla 'tema'
CREATE TABLE `tema` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ;
ALTER TABLE `tema` AUTO_INCREMENT = 1;
-- Crear la tabla 'frase'
CREATE TABLE `frase` (
  `id` int NOT NULL AUTO_INCREMENT,
  `autor_id` int NOT NULL,
  `texto` varchar(1000) NOT NULL,
  `tema` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `autor_id` (`autor_id`),
  KEY `fk_frase_tema` (`tema`),
  CONSTRAINT `fk_frase_tema` FOREIGN KEY (`tema`) REFERENCES `tema` (`name`) ON DELETE SET NULL,
  CONSTRAINT `frase_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`) ON DELETE CASCADE
) ;

