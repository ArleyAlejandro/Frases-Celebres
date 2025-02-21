<?php

class DataBase
{
    private static $_instance;
    private $conn;
    private $configuration;
    
    private function __construct()
    {
        $this->configuration = Config::getInstance();
        
        try {
            $this->conn = new PDO(
                'mysql:host=localhost
                ;dbname=' . $this->configuration->getDbName(),
                $this->configuration->getName(),
                $this->configuration->getPass(),
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
                );
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    
    public function getConnection()
    {
        return $this->conn;
    }
    
    public function closeConnection()
    {
        $this->conn = null;
    }
    
    private function __clone() {}
}
?>
