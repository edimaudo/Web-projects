<?php
// get ID of the contact to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/contact.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$contact = new Contact($db);
 
// set ID property of contact to be read
$contact->id = $id;
 
// read the details of contact to be read
$contact->readOne();

// set page headers
$page_title = "Read contact";
include_once "header.php";
 
// read contacts button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Contacts";
    echo "</a>";
echo "</div>";

// HTML table for displaying a contact details
echo "<table class='table table-hover table-responsive table-bordered'>";
 
    echo "<tr>";
        echo "<td>name</td>";
        echo "<td>{$contact->name}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Phone Number</td>";
        echo "<td>{$contact->phone_number}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>email</td>";
        echo "<td>{$contact->email}</td>";
    echo "</tr>";
 
echo "</table>";
 
// set footer
include_once "footer.php";
?>