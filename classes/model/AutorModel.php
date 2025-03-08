<?php

class AutorModel
{

    private $connection;

    public function __construct()
    {
        $this->connection = DataBase::getInstance();
    }

    public function insert(Autor $author)
    {
        $query = "INSERT INTO autor (name, description) VALUES (:name, :description)";
        $params = [
            ':name' => $author->name,
            ':description' => $author->description
        ];

        return $this->connection->executeQuery($query, $params);
    }

    public function selectAll()
    {
        $query = "SELECT * FROM autor";
        $results = $this->connection->executeQuery($query);

        $authors = [];

        foreach ($results as $row) {

            $author = new Autor();
            $author->__set('id', $row['id']);
            $author->__set('name', $row['name']);
            $author->__set('description', $row['description']);
            $author->__set('url', $row['url']);

            $authors[] = $author;
        }

        return $authors;
    }


    public function update(Autor $autor, $id)
    {

        $query = "UPDATE autor SET name = :name, description = :description WHERE id = :id";
        $params = [
            ':name' => $autor->__get("name"),
            ':description' => $autor->__get("description"),
            ':id' => $id
        ];
    
        return $this->connection->executeQuery($query, $params);
    }



    public function delete($id)
    {
        $query = "DELETE FROM autor WHERE id = :id";
        $params = [':id' => $id];
    
        return $this->connection->executeQuery($query, $params);
    }

    public function countPhrases($autorID)
    {
        $query = "SELECT COUNT(id) as total_frases FROM frase WHERE autor_id = :autorID";
        $params = [':autorID' => $autorID];

        return $this->connection->executeQuery($query, $params, PDO::FETCH_OBJ);
    }
}
