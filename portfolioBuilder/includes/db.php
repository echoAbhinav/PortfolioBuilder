<?php
class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    
    private $dbh;
    private $stmt;
    private $error;
    
    public function __construct() {
        // Set DSN
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=utf8';
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        );
        
        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            error_log("Database Connection Error: " . $this->error);
            die("Database connection failed. Please try again later.");
        }
    }
    
    public function query($sql) {
        try {
            $this->stmt = $this->dbh->prepare($sql);
            return $this;
        } catch(PDOException $e) {
            error_log("Query Preparation Error: " . $e->getMessage());
            die("Database query error occurred.");
        }
    }
    
    public function bind($param, $value, $type = null) {
        try {
            if(is_null($type)) {
                switch(true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            
            $this->stmt->bindValue($param, $value, $type);
            return $this;
        } catch(PDOException $e) {
            error_log("Parameter Binding Error: " . $e->getMessage());
            die("Database parameter binding error.");
        }
    }
    
    public function execute() {
        try {
            return $this->stmt->execute();
        } catch (PDOException $e) {
            error_log("Query Execution Error: " . $e->getMessage());
            error_log("SQL: " . $this->stmt->queryString);
            die("Database query execution failed.");
        }
    }
    
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll();
    }
    
    public function single() {
        $this->execute();
        return $this->stmt->fetch();
    }
    
    public function rowCount() {
        return $this->stmt->rowCount();
    }
    
    public function lastInsertId() {
        return $this->dbh->lastInsertId();
    }
}