<?php
    class Contact{
     
            // database connection and table name
            private $conn;
            private $table_name = "contact";
         
            // object properties
            public $id;
            public $name;
            public $phone_number;
            public $email;
     
            public function __construct($db){
                $this->conn = $db;
            }
     
            // create contact
            function create(){
         
                    //write query
                    $query = "INSERT INTO
                                " . $this->table_name . "
                            SET
                                name=:name, phone_number=:phone_number, email=:email" ;
         
                    $stmt = $this->conn->prepare($query);
         
                    // posted values
                    $this->name=htmlspecialchars(strip_tags($this->name));
                    $this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
                    $this->email=htmlspecialchars(strip_tags($this->email));

             
                    // bind values 
                    $stmt->bindParam(":name", $this->name);
                    $stmt->bindParam(":phone_number", $this->phone_number);
                    $stmt->bindParam(":email", $this->email);

         
                if($stmt->execute()){
                    return true;
                }else{
                    return false;
                }
         
            }

            function readAll($from_record_num, $records_per_page){
             
                $query = "SELECT
                            id, name, phone_number, email
                        FROM
                            " . $this->table_name . "
                        ORDER BY
                            name DESC
                        LIMIT
                           {$from_record_num}, {$records_per_page}";
             
                $stmt = $this->conn->prepare( $query );
                $stmt->execute();
             
                return $stmt;
            }

            // used for paging contacting
            public function countAll(){
             
                $query = "SELECT id FROM " . $this->table_name . "";
             
                $stmt = $this->conn->prepare( $query );
                $stmt->execute();
             
                $num = $stmt->rowCount();
             
                return $num;
            }

            function readOne(){
 
                $query = "SELECT
                            name, phone_number, email
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
             
                $this->name = $row['name'];
                $this->phone_number = $row['phone_number'];
                $this->email = $row['email'];
            }

            function update(){
             
                $query = "UPDATE
                            " . $this->table_name . "
                        SET
                            name = :name,
                            phone_number = :phone_number,
                            email  = :email
                        WHERE
                            id = :id";
             
                $stmt = $this->conn->prepare($query);
             
                // posted values
                $this->name=htmlspecialchars(strip_tags($this->name));
                $this->phone_number=htmlspecialchars(strip_tags($this->phone_number));
                $this->email=htmlspecialchars(strip_tags($this->email));
                $this->id=htmlspecialchars(strip_tags($this->id));
             
                // bind parameters
                $stmt->bindParam(':name', $this->name);
                $stmt->bindParam(':phone_number', $this->phone_number);
                $stmt->bindParam(':email', $this->email);
                $stmt->bindParam(':id', $this->id);
             
                // execute the query
                if($stmt->execute()){
                    return true;
                }
             
                return false;
                 
            }

            // delete the contact
            function delete(){
             
                $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
                 
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $this->id);
             
                if($result = $stmt->execute()){
                    return true;
                }else{
                    return false;
                }
            }


            // read contact by search term
            public function search($search_term, $from_record_num, $records_per_page){
             
                // select query
                $query = "SELECT
                            p.id, p.name, p.phone_number,  p.email
                        FROM
                            " . $this->table_name . " p
                        WHERE
                            p.name LIKE ? OR p.phone_number LIKE ? OR p.email LIKE ?
                        ORDER BY
                            p.name ASC
                        LIMIT
                            ?, ?";
             
                // prepare query statement
                $stmt = $this->conn->prepare( $query );
             
                // bind variable values
                $search_term = "%{$search_term}%";
                $stmt->bindParam(1, $search_term);
                $stmt->bindParam(2, $search_term);
                $stmt->bindParam(3, $from_record_num, PDO::PARAM_INT);
                $stmt->bindParam(4, $records_per_page, PDO::PARAM_INT);
             
                // execute query
                $stmt->execute();
             
                // return values from database
                return $stmt;
            }
             
            public function countAll_BySearch($search_term){
             
                // select query
                $query = "SELECT
                            COUNT(*) as total_rows
                        FROM
                            " . $this->table_name . " p 
                        WHERE
                            p.name LIKE ? OR p.phone_number LIKE ? OR p.email LIKE ?";
             
                // prepare query statement
                $stmt = $this->conn->prepare( $query );
             
                // bind variable values
                $search_term = "%{$search_term}%";
                $stmt->bindParam(1, $search_term);
                $stmt->bindParam(2, $search_term);
             
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
             
                return $row['total_rows'];
            }

    }
?>