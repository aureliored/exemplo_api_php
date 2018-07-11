<?php
namespace Application\Db;
use mysqli;
use PDO;
use Exception;

class Connect   
{
    private $con;

    public function __construct()
    {
        $config = require __APP_ROOT__ . '\\config\\local.php';
        $db = $config['db'];
    
        $username = $db['user'];
        $password = $db['pass'];
        $host = $db['host'];
        $db = $db['db'];
        try {
            $this->con = new PDO("mysql:host={$host};dbname={$db}", $username, $password);     
        } catch (Exception $e) {
            echo $e->message;
        }
    }

    public function getConnect()
    {
        return $this->con;
    }

    public function execute($sql)
    {
        $stmt = $this->con->prepare($sql);
        if (!$stmt) {
            throw new Exception($this->con->errorInfo());
        }
            
        $exec = $stmt->execute();
            
        if(!$exec){
            throw new Exception($stmt->errorInfo()[2]);
        }

        return $exec;
    }

    public function fetchAll($sql){
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}