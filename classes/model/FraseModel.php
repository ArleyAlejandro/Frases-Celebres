<?php

class FraseModel
{

    private $connection;

    public function __construct()
    {
        $this->connection = DataBase::getInstance();
    }

    public function insert(Frase $frase)
    {
        $text = $frase->texto;
        $author = $frase->autor->id;
        $topic = $frase->tema;
        $query = "INSERT INTO frase
             (autor_id, texto, tema) VALUES (:autor_id, :texto, :tema)";
        $params = ['autor_id' => $author, 'texto' => $text, 'tema' => $topic];
        return $this->connection->executeQuery($query, $params);
    }

    public function update(Frase $frase)
    {

        $id = $frase->id;
        $text = $frase->texto;
        $topic = $frase->tema;
        $author = $frase->autor->id;

        $query = 'UPDATE frase SET texto = :text, tema = :tema, autor_id = :autor_id
        WHERE id = :id';

        $params = [':text' => $text, ':tema' => $topic, ':autor_id' => $author, ':id' => $id];
        return $this->connection->executeQuery($query, $params);
    }

    public function selectAll()
    {

        $query = "
            SELECT f.id AS frase_id, f.texto, f.tema, a.id AS autor_id, a.name AS autor_nombre, a.description AS autor_description, a.url AS autor_url 
            FROM frase f
            INNER JOIN autor a ON f.autor_id = a.id";

        $results = $this->connection->executeQuery($query);

        $frases = [];

        foreach ($results as $row) {
            $autor = new Autor();
            $autor->__set('id', $row['autor_id']);
            $autor->__set('name', $row['autor_nombre']);
            $autor->__set('description', $row['autor_description']);
            $autor->__set('url', $row['autor_url']);

            $frase = new Frase();
            $frase->__set('id', $row['frase_id']);
            $frase->__set('texto', $row['texto']);
            $frase->__set('tema', $row['tema']);

            $frase->__set('autor', $autor);

            $frases[] = $frase;
        }

        return $frases;
    }

    public function delete($id)
    {
        $query = 'DELETE FROM frase WHERE id = :id';
        $params = [':id' => $id];
        return $this->connection->executeQuery($query, $params, PDO::FETCH_OBJ);
    }

    public function loadDatabase()
    {
        $query = ' 
                    DROP DATABASE IF EXISTS frases_celebres;

                    -- Crear la base de datos (si no existe)
                    CREATE DATABASE IF NOT EXISTS frases_celebres CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
                    USE frases_celebres;

                    -- Crear la tabla "autor"
                    CREATE TABLE `autor` (
                    `id` int NOT NULL AUTO_INCREMENT,
                    `name` varchar(100) NOT NULL,
                    `description` varchar(255) NOT NULL,
                    `url` varchar(200) DEFAULT NULL,
                    PRIMARY KEY (`id`)
                    ) ;
                    ALTER TABLE `autor` AUTO_INCREMENT = 1;
                    -- Crear la tabla "tema"
                    CREATE TABLE `tema` (
                    `id` int NOT NULL AUTO_INCREMENT,
                    `name` varchar(100) NOT NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `name` (`name`)
                    ) ;
                    ALTER TABLE `tema` AUTO_INCREMENT = 1;
                    -- Crear la tabla "frase"
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
                    ) ;';
        return $this->connection->executeQuery($query);
    }
    // public function selectOne($id)
    // {
    //     $query = "SELECT * FROM frase WHERE id = :id";
    //     $params = [':id'=> $id];
    //     return $this->connection->executeQuery($query, $params, PDO::FETCH_OBJ);
    // }
}
