<?php

class TemaController
{

    private $themeList;
    private $model;
    private $view;
    private $tema;
    private $limit;
    private $offset;
    private $actualPage;
    private $totalPages;

    public function __construct()
    {
        $this->model = new TemaModel();
        $this->view = new TemaView();
        $this->tema = new Tema();
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

        $this->getTemas($this->limit, $this->offset);
        $this->view->show($this->themeList, $this->actualPage, $this->totalPages);
    }

    public function form($params)
    {
        $this->getTemas();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            if (empty($params["name"])) {
                $this->tema->errors["name"] = "Campo obligatorio";
            } else {
                $name = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->tema->__set("name", $name);
            }

            if (empty($this->tema->errors)) {
                $this->model->insert($this->tema);
                header("Location: ?tema/show");
                exit();
            }
        }

        $this->view->form($this->themeList, $this->tema);
    }

    public function editForm($params)
    {
        $this->getTemas();

        // Si me llega por get, guardo el id, para mostrar la info del tema,
        // en los inputs mientras se edita
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $themeId = (int) $params[0];
        }

        foreach ($this->themeList as $theme) {
            if ($themeId == $theme->id) {
                $this->tema->__set("id", $theme->id);
                $this->tema->__set("name", $theme->name);
                $this->tema->__set("totalPhrases", $this->model->countTopics($theme->name)->total_frases);
            }
        }

        // Si me llega por POST, significa que se ha enviado el form de edición
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Tengo un campo hidden en este form, para enviar un id (que es el mismo que
            // me ha llegado por get, se lo pasé a la vista).
            $this->tema->__set("id", $params["id"]);

            if (empty($params["name"])) {
                $this->tema->errors["name"] = "Campo obligatorio";
            } else {
                $name = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->tema->__set("name", $name);
            }

            if (empty($this->tema->errors)) {
                // Aquí hago el update de los valores en la base de datos
                $this->model->update($this->tema, $this->tema->__get("id"));
                header("Location: ?tema/show");
                exit();
            } else {
                var_dump($this->tema->errors);
                echo "Existen errores en el objeto autor.";
            }
        }

        // Muestro mi formulario de edición, le paso a la vista la lista
        // de autores, y la info del autor seleccionado al pulsar el botón editar
        $this->view->editForm($this->themeList, $this->tema);
    }

    public function deleteTema($params)
    {
        $id = $params[0];
        $this->model->delete($id);
        header("location: ?tema/show");
    }

    private function getTemas($limit=null, $offset=null)
    {
        $this->themeList = $this->model->selectAll($limit, $offset);

        foreach ($this->themeList as &$tema) {
            $themeName = $tema->name;
            $totalPhrases = $this->model->countTopics($themeName)->total_frases;
            $tema->totalPhrases = $totalPhrases;
        }
    }
}
