<?php
    class Learn{
     
            // database connection and table name
            private $conn;
            private $table_name = "learn";
         
            // object properties
            public $id;
            public $title;
            public $created;
            public $time_spent;
            public $learning;
            public $resources;
     
            public function __construct($db){
                $this->conn = $db;
            }
     
            // create learning
            function create(){
         
                    //write query
                    $query = "INSERT INTO
                                " . $this->table_name . "
                            SET
                                title=:title, created=:created, time_spent=:time_spent, learning=:learning, resources=:resources" ;
         
                    $stmt = $this->conn->prepare($query);
         
                    // posted values
                    $this->title=htmlspecialchars(strip_tags($this->title));
                    $this->time_spent=htmlspecialchars(strip_tags($this->time_spent));
                    $this->learning=htmlspecialchars(strip_tags($this->learning));
                    $this->resources=htmlspecialchars(strip_tags($this->resources));
                    $this->created = date('Y-m-d H:i:s');// to get date 'created' field
             
                    // bind values 
                    $stmt->bindParam(":title", $this->title);
                    $stmt->bindParam(":time_spent", $this->time_spent);
                    $stmt->bindParam(":learning", $this->learning);
                    $stmt->bindParam(":resources", $this->resources);
                    $stmt->bindParam(":created", $this->created);
         
                if($stmt->execute()){
                    return true;
                }else{
                    return false;
                }
         
            }

            function readAll($from_record_num, $records_per_page){
             
                $query = "SELECT
                            id, title, time_spent, learning, resources, created
                        FROM
                            " . $this->table_name . "
                        ORDER BY
                            created DESC
                        LIMIT
                           {$from_record_num}, {$records_per_page}";
             
                $stmt = $this->conn->prepare( $query );
                $stmt->execute();
             
                return $stmt;
            }

            // used for paging learning
            public function countAll(){
             
                $query = "SELECT id FROM " . $this->table_name . "";
             
                $stmt = $this->conn->prepare( $query );
                $stmt->execute();
             
                $num = $stmt->rowCount();
             
                return $num;
            }

            function readOne(){
 
                $query = "SELECT
                            title, time_spent, learning, resources
                        FROM
                            " . $this->table_name . "
                        WHERE
                            id = ?
                        LIMIT
                            0,1";
             
                $stmt = $this->conn->prepare( $query );
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
             
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
             
                $this->title = $row['title'];
                $this->time_spent = $row['time_spent'];
                $this->learning = $row['learning'];
                $this->resources = $row['resources'];
            }

            function update(){
             
                $query = "UPDATE
                            " . $this->table_name . "
                        SET
                            title = :title,
                            time_spent = :time_spent,
                            learning = :learning,
                            resources  = :resources
                        WHERE
                            id = :id";
             
                $stmt = $this->conn->prepare($query);
             
                // posted values
                $this->title=htmlspecialchars(strip_tags($this->title));
                $this->time_spent=htmlspecialchars(strip_tags($this->time_spent));
                $this->learning=htmlspecialchars(strip_tags($this->learning));
                $this->resources=htmlspecialchars(strip_tags($this->resources));
                $this->id=htmlspecialchars(strip_tags($this->id));
             
                // bind parameters
                $stmt->bindParam(':title', $this->title);
                $stmt->bindParam(':time_spent', $this->time_spent);
                $stmt->bindParam(':learning', $this->learning);
                $stmt->bindParam(':resources', $this->resources);
                $stmt->bindParam(':id', $this->id);
             
                // execute the query
                if($stmt->execute()){
                    return true;
                }
             
                return false;
                 
            }

    }
?>