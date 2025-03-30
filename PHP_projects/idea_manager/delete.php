<?php
// Process delete operation after confirmation
if($_POST){
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/idea.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // prepare idea object
    $idea = new Idea($db);
     
    // set idea id to be deleted
    $idea->id = $_POST['object_id'];
     
    // delete the idea
    if($idea->delete()){
        // Records deleted successfully. Redirect to landing page
        echo "Object was deleted.";
        header("location: index.php");
        exit();
    }
     
    // if unable to delete the idea
    else{
        echo "Unable to delete idea.";
    }
} else {
     // Check existence of id parameter
    if(empty(trim($_GET["id"]))){
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}


?>