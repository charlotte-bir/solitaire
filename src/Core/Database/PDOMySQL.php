<?php
/**
 * src/Core/Database/PDOMySQL.php
 * Classe concrete de connexion a MySQL en utilisant PDO
 */
require_once(__DIR__ . '/AbstractDatabaseLayer.php');

class PDOMySQL extends AbstractDatabaseLayer {

    public function __construct() {
        $this->port = 3306;
        $this->host = '127.0.0.1';
        $this->username = 'root';
        $this->password = '';
        $this->dbName = 'solitaire';
    }

    public function connect() {

        $dsn = 'mysql:host=' . $this->host . ';';
        $dsn .= 'port=' .$this->port . ';';
        $dsn .= 'dbname=' .$this->dbName;
    

        try {
            $this->db = new \PDO($dsn, $this->username, $this->password);
        }catch(\PDOException $e) {
            var_dump($e);
        }
        
    }
}