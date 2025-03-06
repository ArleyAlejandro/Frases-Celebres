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
        $text = $frase->__get("name");
        $author = $frase->__get("author");
        $topic = $frase->__get("topic");

        //         echo "<pre>";
        //         var_dump($frase);
        //         echo "</pre>";

        //         echo "<pre>";
        //         var_dump($author);
        //         echo "</pre>";

        //         echo "<pre>";
        //         var_dump($topic);
        //         echo "</pre>";
        //         die;

        $stmt =  $this->connection->prepare("INSERT INTO frase
             (autor_id, texto, tema) VALUES (:autor_id, :texto, :tema)");
        $stmt->bindParam('autor_id', $author);
        $stmt->bindParam('texto', $text);
        $stmt->bindParam('tema', $topic);
        $stmt->execute();
    }

    public function update(Frase $frase, $id)
    {

        $text = $frase->__get("name");
        $author = $frase->__get("author");
        $topic = $frase->__get("topic");

        $stmt = $this->connection->prepare('UPDATE frase SET
        name = :name
        WHERE id = :id');

        $stmt->bindParam(':name', $text);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    // public function selectAll(){
    //     // Hago un inner join en la base de datos, para obtener el nombre del autor, 
    //     // a partir del autor_id en la tabla frase.
    //     // $stmt = $this->connection->prepare("SELECT f.id AS id, f.texto, f.tema, a.id AS autor_id, a.name AS autor_nombre FROM frase f
    //     //     INNER JOIN autor a ON f.autor_id = a.id;");
    //     $stmt = $this->connection->prepare("
    //     SELECT f.id AS id, f.texto, f.tema, a.id AS autor_id, a.name AS autor_nombre 
    //     FROM frase f
    //     INNER JOIN autor a ON f.autor_id = a.id
    // ");
    //     $stmt->execute();
    //     // return $stmt->fetchAll(PDO::FETCH_ASSOC);
    //     return $stmt->fetchAll(PDO::FETCH_CLASS, "Frase");

    // }


    public function selectAll() {
        // Consulta que trae los datos de la frase junto con los datos del autor
        $stmt = $this->connection->prepare("
            SELECT f.id AS frase_id, f.texto, f.tema, a.id AS autor_id, a.name AS autor_nombre, a.description AS autor_description, a.url AS autor_url 
            FROM frase f
            INNER JOIN autor a ON f.autor_id = a.id
        ");
        $stmt->execute();
        
        // Obtenemos todos los resultados de la consulta
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $frases = [];
        foreach ($results as $row) {
            // Crear un objeto Autor
            $autor = new Autor();
            $autor->__set('id', $row['autor_id']);
            $autor->__set('name', $row['autor_nombre']);
            $autor->__set('description', $row['autor_description']);
            $autor->__set('url', $row['autor_url']);
            
            // Crear un objeto Frase
            $frase = new Frase();
            $frase->__set('id', $row['frase_id']);
            $frase->__set('texto', $row['texto']);
            $frase->__set('tema', $row['tema']);
            
            // Asignar el objeto Autor a la Frase
            $frase->__set('autor', $autor);
            
            // Agregar la Frase con el Autor a la lista
            $frases[] = $frase;
        }
        
        return $frases;
    }
    


    public function selectOne($id)
    {
        $stmt = $this->connection->prepare("SELECT * FROM frase WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        // return $stmt->fetch(PDO::FETCH_ASSOC);
        return $stmt->fetchObject("Frase");
    }
}
