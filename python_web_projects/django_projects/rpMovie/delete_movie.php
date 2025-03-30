<?php
// check if value was posted
if($_POST){
 
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/movie.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // prepare movie object
    $movie = new Movie($db);
     
    // set movie id to be deleted
    $movie->id = $_POST['object_id'];
     
    // delete the movie
    if($movie->delete()){
        echo "Object was deleted.";
    }
     
    // if unable to delete the movie
    else{
        echo "Unable to delete object.";
    }
}
?>