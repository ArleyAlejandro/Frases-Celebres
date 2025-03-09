<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

class AutorController
{

    private $authorList;
    private $model;
    private $view;
    private $author;
    private $limit;
    private $offset;
    private $actualPage;
    private $totalPages;

    public function __construct()
    {
        $this->author = new Autor();
        $this->model = new AutorModel();
        $this->view = new AutorView();
    }

    public function show($params = null)
    {

         /**
         * Verifico si el número de página me llega por get o por post, si me llega por get significa que se ha hecho click en 
         * un botón de siguiente o anterior, si llega por post significa que se ha introducido un número de página 
         * manualmente en el input.
         */
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Número de página específica que se ha introducido en el input
            $this->actualPage = $params["page"];
        }
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            // Página actual por parámetros desde la vista, o sino la inicializo como 1
            $this->actualPage = isset($params[0]) ? (int)$params[0] : 1;
        }

        // Límite de páginas a mostrar
        $this->limit = 10;
        // Variable para decidir en sql a partir de q registro mostrar el límite
        $this->offset = ($this->actualPage - 1) * $this->limit;
        // Total de frases
        $totalFrases = count($this->model->selectAll());
        // Divido el total de frases por el límite para saber cuantas páginas me quedarán, además redondeo hacia arriba
        $this->totalPages = ceil($totalFrases / $this->limit);

        $this->getAutores($this->limit, $this->offset);
        $this->view->show($this->authorList, $this->actualPage, $this->totalPages);
    }

    public function form($params)
    {

        $this->getAutores($this->limit, $this->offset);

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
            $authorId = (int) $params[0];
        }


        // Recorro la lista de autores, para mostrar la info del autor, en el input 
        foreach ($this->authorList as $key => $value) {

            // Busco la frase en mi lista que tiene el mismo id, que 
            // el id que me ha llegado por get, para mostrar su informacion
            // en los inputs de la vista
            if ($value) {

                if ($value->id === $authorId) {
                    $this->author->__set('id', $value->id);
                    $this->author->__set('name', $value->name);
                    $this->author->__set('description', $value->description);
                    $this->author->__set('phrases', $value->phrases);
                    $this->author->__set('url', $value->url);
                } else {
                    // echo "no hay coincidencia";
                }
            } else {
                echo "no existe value";
            }
        }

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
        $this->view->editForm($this->authorList, $this->author);
    }

    public function deleteAutor($params)
    {
        $id = $params[0];
        $this->model->delete($id);
        header("location: ?autor/show");
    }

    /**
     * Devuelve la lista de autores con un campo extra, que indica la cantidad de frases que tiene
     * asociadas dicho autor
     */
    private function getAutores($limit=null, $offset=null)
    {
        $this->authorList = $this->model->selectAll($limit, $offset);

        foreach ($this->authorList as &$autor) {
            /**
             * Aquí cuento cuantas frases tiene en total cada autor,
             *  esto lo uso para  mostrarlo visualmente en la tabla en la columna "NUM". 
             */
            $total_frases = $this->model->countPhrases($autor->id)->total_frases;
            $autor->phrases = $total_frases;
        }
    }
}
