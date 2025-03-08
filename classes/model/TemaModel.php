<?php

class TemaModel
{
    private $connection;

    public function __construct()
    {
        $this->connection = DataBase::getInstance();
    }

    public function selectAll()
    {
        $query = "SELECT * FROM tema";
        $results = $this->connection->executeQuery($query);
        $themes = [];

        foreach ($results as $row) {
            $theme = new Tema();
            $theme->__set("id", $row['id']);
            $theme->__set("name", $row['name']);
            $themes[] = $theme;
        }

        return $themes;
    }
    public function insert(Tema $tema)
    {
        $name = $tema->__get("name");
        $query = "INSERT INTO tema (name) VALUES (:name)";
        $params = [':name' => $name];
        return $this->connection->executeQuery($query, $params);
    }

    public function update(Tema $tema, $id)
    {

        $name = $tema->__get("name");
        $query = 'UPDATE tema SET name = :name WHERE id = :id';
        $params = [':name' => $name,':id' => $id ];
        return $this->connection->executeQuery($query, $params);
        
    }

    public function delete($id)
    {
        $query = 'DELETE FROM tema WHERE id = :id';
        $params = [':id' => $id];
        return $this->connection->executeQuery($query, $params, PDO::FETCH_OBJ);
    }

    public function countTopics($TopicName)
    {
        $query = "select COUNT(id) as total_frases from frase where tema like :TopicName;";
        $params = [':TopicName' => $TopicName];
        return $this->connection->executeQuery($query, $params, PDO::FETCH_OBJ);
    }

    // public function selectOne($id)
    // {
    //     $stmt = $this->connection->prepare("SELECT * FROM tema WHERE id = :id");
    //     $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    //     $stmt->execute();
    //     return $stmt->fetchObject("Tema");
    // }
}
