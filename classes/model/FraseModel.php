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

        $stmt =  $this->connection->prepare("INSERT INTO frase
             (autor_id, texto, tema) VALUES (:autor_id, :texto, :tema)");
        $stmt->bindParam('autor_id', $author);
        $stmt->bindParam('texto', $text);
        $stmt->bindParam('tema', $topic);
        $stmt->execute();
    }

    public function update(Frase $frase)
    {

        $id = $frase->id;
        $text = $frase->texto;
        $topic = $frase->tema;
        $author = $frase->autor->id;

        $stmt = $this->connection->prepare('UPDATE frase SET
        texto = :text,
        tema = :tema,
        autor_id = :autor_id
        WHERE id = :id');

        $stmt->bindParam(':text', $text);
        $stmt->bindParam(':tema', $topic);
        $stmt->bindParam(':autor_id', $author);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function selectAll()
    {
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
        $stmt = $this->connection->prepare('DELETE FROM frase WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
