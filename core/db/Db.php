<?php
namespace app\core\db;

class Db{

    protected $db;
    protected $stmt;

    public function __construct(){
        $this->getConnect();
    }

    public function getQuery($query, $args = null){
        $this->query($query, $args);
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getOneQuery($query, $args = null){
        $this->query($query, $args);
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function setQuery($query, $args = null, $typeQuery = 1){
        $this->query($query, $args);


        return  $typeQuery == 1 ? $this->db->lastInsertId() : $this->stmt->rowCount() ;
    }

    public function query($query, $args = null){

        $this->stmt = $this->db->prepare($query);

        $this->stmt->execute($args);
    }

    public function getDbConnect(){
        return $this->db;
    }

    protected function getConnect(){
        $config = require APP_DIR."/config/db.php";

        $this->db = new \PDO("mysql:dbname={$config['dbname']};host={$config['dbhost']}", $config['dbuser'], $config['dbpassword']);
    }
}
