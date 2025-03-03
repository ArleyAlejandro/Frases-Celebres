<?php

class TemaController{
    
    private $temaList;
    private $model;
    private $view;
    private $tema;
    
    public function __construct()
    {
        $this->model = new TemaModel();
        $this->view = new TemaView();
        $this->tema = new Tema();
    }
    
    public function show($params = null)
    {
        $this->getTemas();
        $this->view->show($this->temaList);
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
        
        $this->view->form($this->temaList, $this->tema);
    }
    
    public function editForm($params)
    {
        $this->getTemas();
        
        // Si me llega por get, guardo el id, para mostrar la info del tema,
        // en los inputs mientras se edita
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            $this->tema->__set("id", $params[0]);
        }
        
        // info del autor, a partir del id q me ha llegado por GET
        $temaInfo = $this->model->selectOne($this->tema->__get("id"));
//         echo "<pre>";
//         var_dump($temaInfo);
//         echo "</pre>";
//         echo $temaInfo->name;
        
//         die;
        
        
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
        $this->view->editForm($this->temaList, $temaInfo);
    }
    
    public function deleteTema($params){
        $id = $params[0];
        $this->model->delete($id);
        header("location: ?tema/show");
    }
    
    private function getTemas(){
        $this->temaList = $this->model->selectAll();
//         echo "<pre>";
//         var_dump($this->temaList);
//         echo "</pre>";
        
        foreach ($this->temaList as &$tema) {
            
//             echo $tema;
//             echo "<pre>";
//             var_dump($tema);
//             echo "</pre>";
            
//             echo $tema["name"];
//         die;
//         echo $tema[0]["name"];
            
            $totalTemas = $this->model->countTopics($tema["name"]);
            $tema["total_frases"] = $totalTemas["total_frases"];
        }
    }
    
}