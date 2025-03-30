<?php
// get ID of the movie to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/movie.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$movie = new Movie($db);
 
// set ID property of movie to be read
$movie->id = $id;
 
// read the details of movie to be read
$movie->readOne();

// set page headers
$page_title = "Movie";
include_once "header.php";
 
// read movies button
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-primary pull-right'>";
        echo "<span class='glyphicon glyphicon-list'></span> Movies";
    echo "</a>";
echo "</div>";

// HTML table for displaying a movie details
echo "<table class='table table-hover table-responsive table-bordered'>";
 
    echo "<tr>";
        echo "<td>Title</td>";
        echo "<td>{$movie->title}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Release Date</td>";
        echo "<td>{$movie->release_date}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Genre</td>";
        echo "<td>{$movie->genre}</td>";
    echo "</tr>";
 
    echo "<tr>";
        echo "<td>Price</td>";
        echo "<td>{$movie->price}</td>";
    echo "</tr>";
 
echo "</table>";
 
// set footer
include_once "footer.php";
?>