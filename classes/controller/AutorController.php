<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

class AutorController
{

    private $authorList;

    private $model;

    private $view;

    private $author;

    public function __construct()
    {
        $this->model = new AutorModel();
        $this->view = new AutorView();
        $this->author = new Autor();
    }

    public function show($params = null)
    {
        $this->getAutores();
        $this->view->show($this->authorList);
    }

    public function form($params)
    {
        $this->getAutores();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($params["name"])) {
                $this->author->errors["name"] = "Campo obligatorio";
            } else {
                $name = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->author->__set("name", $name);
            }

            if (empty($params["description"])) {
                $this->author->errors["description"] = "Campo obligatorio";
            } else {
                $description = filter_var($params["description"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->author->__set("description", $description);
            }

            if (empty($this->author->errors)) {
                $this->model->insert($this->author);
                header("Location: ?autor/show");
                exit();
            }
        }

        $this->view->form($this->authorList, $this->author);
    }

    public function editForm($params)
    {
        $this->getAutores();

        // Si me llega por get, guardo el id, para mostrar la info del autor, 
        // en los inputs mientras se edita
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->author->__set("id", $params[0]);
        }
        
        // info del autor, a partir del id q me ha llegado por GET
        $authorInfo = $this->model->selectOne($this->author->__get("id"));

        // Si me llega por POST, significa que se ha enviado el form de edición
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Tengo un campo hidden en este form, para enviar un id (que es el mismo que 
            // me ha llegado por get, se lo pasé a la vista).
            $this->author->__set("id", $params["id"]);

            if (empty($params["name"])) {
                $this->author->errors["name"] = "Campo obligatorio";
            } else {
                $name = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->author->__set("name", $name);
            }

            if (empty($params["description"])) {
                $this->author->errors["description"] = "Campo obligatorio";
            } else {
                $description = filter_var($params["description"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->author->__set("description", $description);
            }

            if (empty($this->author->errors)) {
                // Aquí hago el update de los valores en la base de datos 
                $this->model->update($this->author, $this->author->__get("id"));
                header("Location: ?autor/show");
                exit();
            } else {
                echo "Existen errores en el objeto autor.";
            }
        }
        
        // Muestro mi formulario de edición, le paso a la vista la lista 
        // de autores, y la info del autor seleccionado al pulsar el botón editar
        $this->view->editForm($this->authorList, $authorInfo);
    }
    
    public function deleteAutor($params){
       
       $id = $params[0];
       $this->model->delete($id);
       header("location: ?autor/show");
    }

    /**
     * Devuelve la lista de autores con un campo extra, que indica la cantidad de frases que tiene
     * asociadas dicho autor
     */
    private function getAutores()
    {
        $this->authorList = $this->model->selectAll();

        foreach ($this->authorList as &$autor) {

            $totalFrases = $this->model->countPhrases($autor["id"]);
            $autor["total_frases"] = $totalFrases["total_frases"];
        }
    }
}

