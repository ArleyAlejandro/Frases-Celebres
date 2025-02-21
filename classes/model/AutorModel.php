<?php

class AutorModel{
    
    private $connection;
    
    public function __construct(){
        $this->connection = DataBase::getInstance();
    }
    
   
        
//         if ( $this->connection) {
//             echo "Conexion exitosa desde el autoModel";
//         }else{
//             echo "Conexion fallida desde el autoModel";
//         }
        
    

}

