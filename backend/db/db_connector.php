<?php
// Connect to the db
require_once('db_creator.php');
class DBConnector
{
    private static $instance = null;
    private $conn;

    private $host = 'localhost';
    private $user = 'root';
    private $pass = 'root';
    private $db = 'evcs';

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new DBConnector();
        }
 
        return self::$instance;
    }

  
    public function connect_host()
    {
        $this->conn = mysqli_connect($this->host, $this->user, $this->pass);
        return $this->conn;
    }
    public function connect_db()
    {
        if ($this->conn == null) {
            $this->conn = $this->connect_host();
        }
        if (mysqli_select_db($this->conn, $this->db)) {
            return $this->conn;
        } else {
            $this->create_db($this->conn);
            return $this->conn;
        }
    }
    private function create_db($conn)
    {
        $db_creator = new DBCreator();
        $db_creator->create($conn);
    }
}
?>