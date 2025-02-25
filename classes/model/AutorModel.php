<?php

class AutorModel{
    
    private $connection;
    
    public function __construct(){
        $this->connection = DataBase::getInstance();
//         echo "<pre>";
//         var_dump($this->connection) ;
//         echo "</pre>";
//         die;
    }
    
    public function insert(Autor $autor){   
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
    
    public function countPhrases($autorID) {
        $stmt = $this->connection->prepare("SELECT COUNT(id) as total_frases FROM frase WHERE autor_id = :autorID");
        $stmt->bindParam(':autorID', $autorID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
        
        //         SELECT count(id) as autor_id FROM frases_celebres.frase where autor_id like 3;
        //         select * from frases_celebres.frase where autor_id like 3;
    }
    
    public function update(Autor $autor, $id){
        
    }
    
    public function delete($id){
        
    }
    
}

