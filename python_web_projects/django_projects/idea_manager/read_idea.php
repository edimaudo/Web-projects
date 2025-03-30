<?php
// get ID of the idea to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/idea.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$idea = new Idea($db);
 
// set ID property of idea to be read
$idea->id = $id;
 
// read the details of idea to be read
$idea->readOne();

// set page headers
$page_title = "Idea"; //$page_name
include_once "header.php";
 
// read ideas button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Ideas";
    echo "</a>";
echo "</div>";

// HTML table for displaying a idea details
echo "<table class='table table-hover table-responsive table-bordered'>";
 
    echo "<tr>";
        echo "<td>name</td>";
        echo "<td>{$idea->name}</td>";
    echo "</tr>";
  
    echo "<tr>";
        echo "<td>description</td>";
        echo "<td>{$idea->description}</td>";
    echo "</tr>";
 
echo "</table>";
 
// set footer
include_once "footer.php";
?>