<?php

class FraseModel
{
    
    private $connection;
    
    public function __construct(){
        $this->connection = DataBase::getInstance();
    }
    
    public function insert(){
        
    }
    
    public function selectAll(){
        // Hago un inner join en la base de datos, para obtener el nombre del autor, 
        // a partir del autor_id en la tabla frase.
        $stmt = $this->connection->prepare("SELECT f.id AS frase_id, f.texto, f.tema, a.id AS autor_id, a.name AS autor_nombre FROM frase f
            INNER JOIN autor a ON f.autor_id = a.id;");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}

