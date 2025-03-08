<?php

class TemaModel{
    private $connection;
    
    public function __construct(){
        $this->connection = DataBase::getInstance();
    }
    
    public function insert(Tema $tema){
        $name = $tema->__get("name");
        
        $stmt =  $this->connection->prepare("INSERT INTO tema
             (name) VALUES (:name)");
        $stmt->bindParam('name', $name);
        $stmt->execute();
    }   
    
    public function selectAll(){
        $stmt = $this->connection->prepare("SELECT * FROM tema");
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $themes = [];

        foreach ($results as $row) {
            $theme = new Tema();
            $theme->__set("id",$row['id']);
            $theme->__set("name",$row['name']);

            $themes[] = $theme;
        }

        return $themes;
    }
    
    public function update(Tema $tema, $id) {
        
        $name = $tema->__get("name");
        
        $stmt = $this->connection->prepare('UPDATE tema SET
        name = :name
        WHERE id = :id');
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
    
    public function delete($id){
        $stmt = $this->connection->prepare('DELETE FROM tema WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function countTopics($TopicName) {
        $stmt = $this->connection->prepare("select COUNT(id) as total_frases from frase where tema like :TopicName;");
        $stmt->bindParam(':TopicName', $TopicName);
        $stmt->execute();
        return $stmt->fetchObject();
    }
    
    public function selectOne($id){
        $stmt = $this->connection->prepare("SELECT * FROM tema WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchObject("Tema");
    }
}