<?php

class AutorModel{
    
    private $connection;
    
    public function __construct(){
        $this->connection = DataBase::getInstance();
    }
    
    public function insert(Autor $autor){   
        $name = $autor->__get("name");
        $description = $autor->__get("description");
        
        $stmt =  $this->connection->prepare("INSERT INTO autor
             (name, description) VALUES (:name, :description)");
        $stmt->bindParam('name', $name);
        $stmt->bindParam('description', $description);
        $stmt->execute();
    }   
    
    public function selectAll(){
        $stmt = $this->connection->prepare("SELECT * FROM autor");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    public function update(Autor $autor, $id) {
      
        $name = $autor->__get("name");
        $description =  $autor->__get("description");

        $stmt = $this->connection->prepare('UPDATE autor SET
        name = :name,
        description = :description
        WHERE id = :id');
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    
    
    public function delete($id){
        $stmt = $this->connection->prepare('DELETE FROM autor WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    /**
     * Uso esta función, para contar cuantas frases están asociadas a cada autor, y 
     * mostrar esa cifra en la tabla de la vista (AuthorView)
     */
    public function countPhrases($autorID) {
        $stmt = $this->connection->prepare("SELECT COUNT(id) as total_frases FROM frase WHERE autor_id = :autorID");
        $stmt->bindParam(':autorID', $autorID);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /**
     * Utilizo esta función para seleccionar un autor desde la base de datos, a partir 
     * del id, lo necesitaba para mostrar la info del autor en los inputs al editar.
     */
    public function selectOne($id){
        $stmt = $this->connection->prepare("SELECT * FROM autor WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
//     public function selectOneByName($name){
//         $stmt = $this->connection->prepare("SELECT * FROM autor WHERE name like :name");
//         $stmt->bindParam(':name', $name);
//         $stmt->execute();
//         return $stmt->fetchAll(PDO::FETCH_ASSOC);
//     }
    
}

