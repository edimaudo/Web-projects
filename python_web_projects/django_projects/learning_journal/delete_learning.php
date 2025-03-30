<?php
// check if value was posted
if($_POST){
 
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/learn.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // prepare learn object
    $learn = new Learn($db);
     
    // set learn id to be deleted
    $learn->id = $_POST['object_id'];
     
    // delete the learn
    if($learn->delete()){
        echo "Object was deleted.";
    }
     
    // if unable to delete the learn
    else{
        echo "Unable to delete object.";
    }
}
?>