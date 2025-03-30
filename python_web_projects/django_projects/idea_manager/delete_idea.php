<?php
// check if value was posted
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
        echo "Object was deleted.";
    }
     
    // if unable to delete the idea
    else{
        echo "Unable to delete object.";
    }
}
?>