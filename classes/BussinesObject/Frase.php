<?php

class Frase
{
    private $id;
    private $autor;
    private $tema;
    private $texto;
    private $errors = [];
    
    public function __construct(){}
    
    public function __get($prop) {
        if (property_exists($this, $prop)) {
            return $this->$prop;
        }else{
            throw new Exception("No se puede hacer Get, propiedad inexistente: ".$prop);
        }
    }
    
    public function __set($prop, $val) {
        if (property_exists($this, $prop)) {
            $this->$prop = $val;
        }else{
            throw new Exception("No se puede hacer Set, propiedad inexistente: ".$prop);
        }
    }
   
}

