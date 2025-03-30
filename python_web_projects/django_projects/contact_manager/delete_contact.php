<?php
// check if value was posted
if($_POST){
 
    // include database and object file
    include_once 'config/database.php';
    include_once 'objects/contact.php';
 
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
 
    // prepare contact object
    $contact = new Contact($db);
     
    // set contact id to be deleted
    $contact->id = $_POST['object_id'];
     
    // delete the contact
    if($contact->delete()){
        echo "Contact was deleted.";
    }
     
    // if unable to delete the contact
    else{
        echo "Unable to delete Contact.";
    }
}
?>