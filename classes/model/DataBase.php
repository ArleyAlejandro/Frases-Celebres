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
            $this->conn = new PDO('mysql:host=localhost;dbname=' . $this->configuration->getDbName(),
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
    
    public function executeQuery($query, $params = [], $fetchMode = PDO::FETCH_ASSOC, $className = null)
    {
        $stmt = $this->conn->prepare($query);
        
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
    
        $stmt->execute();
    
        if ($fetchMode === PDO::FETCH_OBJ || $fetchMode === PDO::FETCH_CLASS) {
            return $stmt->fetchObject($className);
        }
    
        return $stmt->fetchAll($fetchMode);
    }
    
    
    public function getConnection()
    {
        return $this->conn;
    }

    public function getLastInsertId()
{
    return $this->conn->lastInsertId();
}

    
    public function closeConnection()
    {
        $this->conn = null;
    }
    
    private function __clone() {}
}
?>
