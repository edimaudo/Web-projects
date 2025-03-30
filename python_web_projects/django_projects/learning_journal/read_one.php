<?php
// get ID of the learn to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/learn.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$learn = new learn($db);
 
// set ID property of learn to be read
$learn->id = $id;
 
// read the details of learn to be read
$learn->readOne();

// set page headers
$page_title = "Read One Learning";
include_once "header.php";
 
// read learns button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Read Learning";
    echo "</a>";
echo "</div>";

// HTML table for displaying a learn details
echo "<table class='table table-hover table-responsive table-bordered'>";
 
    echo "<tr>";
        echo "<td>Title</td>";
        echo "<td>{$learn->title}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Time spent</td>";
        echo "<td>{$learn->time_spent}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Learning</td>";
        echo "<td>{$learn->learning}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Resources</td>";
        echo "<td>{$learn->resources}</td>";
    echo "</tr>";
 
echo "</table>";
 
// set footer
include_once "footer.php";
?>