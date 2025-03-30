

<?php
class Database{
    /* Database credentials. Assuming you are running MySQL
   server with default setting (user 'root' with no password) */
    // specify your own database credentials
    private $db_server = "localhost";
    private $db_name = "";
    private $db_username = "";
    private $db_password = ""; 
    public $conn;
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->db_server . ";dbname=" . $this->db_name, $this->db_username, $this->db_password);
        }catch(PDOException $exception){
            die("ERROR: Could not connect. " . $exception->getMessage());
        }
  
        return $this->conn;
    }
}
?>