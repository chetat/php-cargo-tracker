<?php
class Database{
  
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "tracker_web";
    private $username = "phpmyadmin" ;
    private $password = "weezybaby";
    public $conn;
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password, $options);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>
