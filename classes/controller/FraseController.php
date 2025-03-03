<?php

class FraseController
{
    
    private $fraseList;
    private $autorModel;
    private $temaModel;
    private $model;
    private $view;
    private $frase;

    public function __construct(){
        $this->model = new FraseModel();
        $this->temaModel = new TemaModel();
        $this->autorModel = new AutorModel();
        $this->frase = new Frase();
        $this->view = new FraseView();
    }
    
    public function show(){
        $this->fraseList = $this->model->selectAll();
        
//         echo "<pre>";
//         var_dump($this->fraseList);
//         echo "</pre>";
//         die;
        $this->view->show($this->fraseList);
    }
    
    public function form($params)
    {
        $this->fraseList = $this->model->selectAll();
        $temas = $this->temaModel->selectAll();
        $autores = $this->autorModel->selectAll();
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (empty($params["frase"])) {
                $this->frase->errors["frase"] = "Campo obligatorio";
            } else {
                $frase = filter_var($params["frase"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
                $this->frase->__set("frase", $frase);
            }
            
//             if (empty($params["description"])) {
//                 $this->author->errors["description"] = "Campo obligatorio";
//             } else {
//                 $description = filter_var($params["description"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
//                 $this->author->__set("description", $description);
//             }
            
//             if (empty($this->frase->errors)) {
//                 $this->model->insert($this->frase);
//                 header("Location: ?frase/show");
//                 exit();
//             }
        }
        
        
        $this->view->form($this->fraseList, $this->frase, $temas, $autores);
    }
    
    public function editForm(){
        
    }
}

