<?php
    class Movie{
     
            // database connection and table name
            private $conn;
            private $table_name = "movie";
         
            // object properties
            public $id;
            public $title;
            public $release_date;
            public $genre;
            public $price;
                 
            public function __construct($db){
                $this->conn = $db;
            }
     
            // create movie
            function create(){
         
                    //write query
                    $query = "INSERT INTO
                                " . $this->table_name . "
                            SET
                                title=:title, genre=:genre, release_date=:release_date, price=:price" ;
         
                    $stmt = $this->conn->prepare($query);
         
                    // posted values
                    $this->title=htmlspecialchars(strip_tags($this->title));
                    $this->release_date=htmlspecialchars(strip_tags($this->release_date));
                    $this->genre=htmlspecialchars(strip_tags($this->genre));
                    $this->price=htmlspecialchars(strip_tags($this->price));
                    
             
                    // bind values 
                    $stmt->bindParam(":title", $this->title);
                    $stmt->bindParam(":release_date", $this->release_date);
                    $stmt->bindParam(":price", $this->price);
                    $stmt->bindParam(":genre", $this->genre);
         
                if($stmt->execute()){
                    return true;
                }else{
                    return false;
                }
         
            }

            function readAll($from_record_num, $records_per_page){
             
                $query = "SELECT
                            id, title, release_date, price, genre
                        FROM
                            " . $this->table_name . "
                        ORDER BY
                            title DESC
                        LIMIT
                           {$from_record_num}, {$records_per_page}";
             
                $stmt = $this->conn->prepare( $query );
                $stmt->execute();
             
                return $stmt;
            }

            // used for paging movie
            public function countAll(){
             
                $query = "SELECT id FROM " . $this->table_name . "";
             
                $stmt = $this->conn->prepare( $query );
                $stmt->execute();
             
                $num = $stmt->rowCount();
             
                return $num;
            }

            function readOne(){
 
                $query = "SELECT
                            title, release_date, genre, price
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
                $this->release_date = $row['release_date'];
                $this->genre = $row['genre'];
                $this->price = $row['price'];
            }

            function update(){
             
                $query = "UPDATE
                            " . $this->table_name . "
                        SET
                            title = :title,
                            release_date = :release_date,
                            genre = :genre,
                            price  = :price
                        WHERE
                            id = :id";
             
                $stmt = $this->conn->prepare($query);
             
                // posted values
                $this->title=htmlspecialchars(strip_tags($this->title));
                $this->release_date=htmlspecialchars(strip_tags($this->release_date));
                $this->genre=htmlspecialchars(strip_tags($this->genre));
                $this->price=htmlspecialchars(strip_tags($this->price));
                $this->id=htmlspecialchars(strip_tags($this->id));
             
                // bind parameters
                $stmt->bindParam(':title', $this->title);
                $stmt->bindParam(':release_date', $this->release_date);
                $stmt->bindParam(':price', $this->price);
                $stmt->bindParam(':genre', $this->genre);
                $stmt->bindParam(':id', $this->id);
             
                // execute the query
                if($stmt->execute()){
                    return true;
                }
             
                return false;
                 
            }

            // delete the movie
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


            // read movie by search term
            public function search($search_term, $from_record_num, $records_per_page){
             
                // select query
                $query = "SELECT
                            p.id, p.title, p.release_date, p.price, p.genre
                        FROM
                            " . $this->table_name . " p
                        WHERE
                            p.title LIKE ? OR p.genre LIKE ? OR p.price LIKE ? OR p.release_date LIKE ?
                        ORDER BY
                            p.title ASC
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
                            p.title LIKE ? OR p.genre LIKE ?";
             
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