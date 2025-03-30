<?php
class Database{
  
    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "movie";
    private $username = "";//delete before pushing to github
    private $password = "";//delete before pushing to github
    public $conn;
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>