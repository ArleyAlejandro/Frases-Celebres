-- DROP DATABASE IF EXISTS frases_celebres;

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
  `texto` varchar(400) NOT NULL,
  `tema` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `autor_id` (`autor_id`),
  KEY `fk_frase_tema` (`tema`),
  CONSTRAINT `fk_frase_tema` FOREIGN KEY (`tema`) REFERENCES `tema` (`name`) ON DELETE SET NULL,
  CONSTRAINT `frase_ibfk_1` FOREIGN KEY (`autor_id`) REFERENCES `autor` (`id`) ON DELETE CASCADE
) ;

-- Insertar datos en la tabla 'autor'
INSERT INTO `autor` (`name`, `description`, `url`) VALUES
('Albert Einstein', 'Físico teórico alemán, conocido por desarrollar la teoría de la relatividad.', 'https://es.wikipedia.org/wiki/Albert_Einstein'),
('Mahatma Gandhi', 'Líder del movimiento independentista indio.', 'https://es.wikipedia.org/wiki/Mahatma_Gandhi'),
('Friedrich Nietzsche', 'Filósofo alemán, conocido por su concepto del superhombre.', 'https://es.wikipedia.org/wiki/Friedrich_Nietzsche'),
('Marie Curie', 'Científica pionera en el campo de la radiactividad, ganadora de dos premios Nobel.', 'https://es.wikipedia.org/wiki/Marie_Curie');

-- Insertar datos en la tabla 'tema'
INSERT INTO `tema` (`name`) VALUES
('Filosofía'),
('Ciencia'),
('Independencia'),
('Educación');

-- Insertar datos en la tabla 'frase'
INSERT INTO `frase` (`autor_id`, `texto`, `tema`) VALUES
(1, 'La vida es como andar en bicicleta. Para mantener el equilibrio, debes seguir adelante.', 'Ciencia'),
(1, 'La imaginación es más importante que el conocimiento.', 'Ciencia'),
(2, 'Sé el cambio que deseas ver en el mundo.', 'Independencia'),
(2, 'La fuerza no proviene de la capacidad física, sino de una voluntad indomable.', 'Independencia'),
(3, 'Lo que no nos mata nos hace más fuertes.', 'Filosofía'),
(3, 'El hombre es algo que debe ser superado.', 'Filosofía'),
(4, 'Nada en la vida es de temer, solo de comprender.', 'Educación'),
(4, 'En la ciencia, no se puede hacer nada sin experimentar.', 'Ciencia');
