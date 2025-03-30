<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

    $id = $_GET['id'];
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
        $page_title = "Read Idea"; //$page_name
        include_once "templates/header.php";
         
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
        include_once "templates/footer.php";
    



} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}

?>