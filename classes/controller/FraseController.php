<?php

class FraseController
{

    public function __construct(){}
    
    public function show($params = null){
        
        $vFrase = new FraseView();
        $vFrase->show();
        
      
    }
    
    public function createForm($params){
        
        //         $model = new AutorModel();
        //         $autor = new Autor();
        
        //         if (empty($params["name"])) {
        //             $errors["name"] ="Campo 'name' obligatorio";
        //         }else{
        //             $name = filter_var($params["name"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //             $autor->__set("name", $name);
        //         }
        
        //         if (empty($params["description"])) {
        //             $errors["description"] ="Campo 'description' obligatorio";
        //         }else{
        //             $description = filter_var($params["description"], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        //             $autor->__set("description", $description);
        //         }
        
        
        $vAutor = new AutorView();
        $vAutor->form();
    }
    
    public function editForm($params){
        $vAutor = new AutorView();
        $vAutor->editForm();
    }
}

