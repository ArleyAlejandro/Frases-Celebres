<?php

class Autor{
    
    private $name;
    private $description;
    private $phrases;
    private $url;

    public function __construct(){}
    
    public function __get($prop) {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }else{
            throw new Exception("Propiedad inexistente");
        }
    }
    
    public function __set($prop, $val) {
        if (property_exists($this, $prop)) {
            $this->$prop = $val;
        }else{
            throw new Exception("Propiedad inexistente");
        }
    }
    
}