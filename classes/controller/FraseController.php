<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);
class FraseController
{

    private $fraseList;
    private $autorModel;
    private $temaModel;
    private $model;
    private $view;
    private $frase;

    public function __construct()
    {
        $this->model = new FraseModel();
        $this->temaModel = new TemaModel();
        $this->autorModel = new AutorModel();
        $this->frase = new Frase();
        $this->view = new FraseView();
    }

    public function show()
    {
        $this->fraseList = $this->model->selectAll();
        $this->view->show($this->fraseList);

        // echo "<pre>";
        // var_dump($this->fraseList);
        // echo "</pre>";
        // die;
    }

    public function form($params)
    {
        $this->fraseList = $this->model->selectAll();
        $temas = $this->temaModel->selectAll();
        $autores = $this->autorModel->selectAll();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // echo "<pre>";
            // var_dump($params);
            // echo "</pre>";
            // die;

            if (empty($params["name"])) {
                $this->frase->errors["name"] = "Campo obligatorio";
            } else {
                $frase = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("texto", $frase);
                echo "name frase -> ok" . "<br>";
            }


            if (empty($params["author"])) {
                $this->frase->errors["author"] = "Campo obligatorio";
            } else {

                echo "author frase -> ok" . "<br>";
                $authorid = filter_var($params["author"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $authorData = $this->autorModel->selectOne($authorid);
                
                if ($authorData) {
                    $autor = new Autor();
                    $autor->__set("id", $authorData["id"]);
                    $autor->__set("name", $authorData["name"]);
                    $autor->__set("description", $authorData["description"]);
                    $autor->__set("url", $authorData["url"]);
                } else {
                    $this->frase->errors["author"] = "El autor no existe.";
                    return;
                }

                $this->frase->__set("autor", $autor);
            }



            if (empty($params["topic"])) {
                $this->frase->errors["topic"] = "Campo obligatorio";
            } else {
                $frase = filter_var($params["topic"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("tema", $frase);
                echo "tema frase -> ok" . "<br>";
            }

            if (empty($this->frase->errors)) {
                // echo "<pre>";
                // var_dump($this->frase);
                // echo "</pre>";
                // die;
                // $autor_id = $this->frase->autor->__get("id");

                $this->model->insert($this->frase);
                header("Location: ?frase/show");
                exit();
            } else {
                echo "Error al insertar";
            }
        }

        // Mando una lista de autores y temas a la ista, para mostrarlos 
        // en los inputs de tipo select.
        $this->view->form($this->fraseList, $this->frase, $temas, $autores);
    }

    public function editForm($params)
    {

        $this->fraseList = $this->model->selectAll();
        $temas = $this->temaModel->selectAll();
        $autores = $this->autorModel->selectAll();

        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $fraseId = (int) $params[0];
        }

        foreach ($this->fraseList as $key => $value) {

            // Busco la frase en mi lista que tiene el mismo id, que 
            // el id que me ha llegado por get, para mostrar su informacion
            // en los inputs de la vista
            if ($value) {
                if ($value->id === $fraseId) {
                    $this->frase->__set('id', $value->id);
                    $this->frase->__set('texto', $value->texto);
                    $this->frase->__set('tema', $value->tema);
                    $this->frase->__set('autor', $value->autor);
                } else {
                    // echo "no hay coincidencia";
                }
            } else {
                echo "no existe value";
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $this->frase->__set("id", $params["id"]);

            if (empty($params["name"])) {
                $this->frase->errors["name"] = "Campo obligatorio";
            } else {
                $fraseTexto = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("texto", $fraseTexto);
                //                 echo "ok";
            }


            if (empty($params["author"])) {
                $this->frase->errors["author"] = "Campo obligatorio";
            } else {
                $author = filter_var($params["author"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $autor = new Autor();
                $autor->__set("id", $params["author"]);
                $this->frase->__set("autor", $autor);
            }


            if (empty($params["topic"])) {
                $this->frase->errors["topic"] = "Campo obligatorio";
            } else {
                $tema = filter_var($params["topic"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("tema", $tema);
            }


            if (empty($this->frase->errors)) {
                $this->model->update($this->frase);
                // echo "ok";
                header("Location: ?frase/show");
                exit();
            } else {
                echo "hay errores";
            }
        }

        // Mando una lista de autores y temas a la ista, para mostrarlos
        // en los inputs de tipo select.
        $this->view->editForm($this->fraseList, $this->frase, $temas, $autores);
    }

    public function deleteFrase($params)
    {
        $id = $params[0];
        $this->model->delete($id);
        header("location: ?frase/show");
    }
}
