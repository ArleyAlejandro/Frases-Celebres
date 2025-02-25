<?php

class AutorController
{

    private $autores;

    public function __construct()
    {}

    public function show($params = null)
    {
        $this->getAutores();

        // echo "<pre>";
        // var_dump($autores);
        // echo "</pre>";

        // echo "<pre>";
        // var_dump($autores);
        // echo "</pre>";

        // foreach ($autores as $autor) {
        // echo $autor["name"] . "<br>";
        // }

        $vAutor = new AutorView();
        $vAutor->show($this->autores);

        // if ($params == null) {
        // echo "no params";
        // }else{
        // echo "<pre>";
        // var_dump($params) ;
        // echo "</pre>";
        // }
    }

    public function createForm($params)
    {
        $this->getAutores();

        $model = new AutorModel();
        $autor = new Autor();

        if (empty($params["name"])) {
            $errors["name"] = "Campo 'name' obligatorio";
        } else {
            $name = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $autor->__set("name", $name);
        }

        if (empty($params["description"])) {
            $errors["description"] = "Campo 'description' obligatorio";
        } else {
            $description = filter_var($params["description"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $autor->__set("description", $description);
        }

        $vAutor = new AutorView();
        $vAutor->createForm($this->autores);
    }

    public function editForm($params)
    {
        
        $this->getAutores();
        
        $vAutor = new AutorView();
        $vAutor->editForm($this->autores);
    }

    private function getAutores()
    {
        $model = new AutorModel();
        $this->autores = $model->selectAll();

        foreach ($this->autores as &$autor) {

            $totalFrases = $model->countPhrases($autor["id"]);
            $autor["total_frases"] = $totalFrases["total_frases"];
        }
    }
}

