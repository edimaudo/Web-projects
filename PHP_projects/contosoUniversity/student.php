<?php
include('header.php');
?>

<html>
<div class="container">
        <main role="main" class="pb-3">
<h2>Students</h2>

<p>
    <a href="student_create.php">Create New</a>
</p>
<form method="get" action="/Student">
    <div class="form-actions no-color">
        <p>
            Find by name: <input type="text" id="SearchString" name="SearchString">
            <input type="submit" value="Search" id="SearchButton" class="btn btn-default"> |
            <a href="/Student">Back to Full List</a>
        </p>
    </div>
</form>


<?php
include 'functions.php';
$pdo = pdo_connect_mysql();


$sql = "SELECT * FROM Student";
if($result = $pdo->query($sql)){
    if($result->rowCount() > 0){
        echo '<table class="table"> ';
        echo "<thead>";
        echo "<tr>";
        echo "<th> Last Name </th>";
        echo "<th> First Name </th>";
        echo "<th> Enrollment Date </th>";
        echo "<th></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['LastName'] . "</td>";
                                        echo "<td>" . $row['FirstName'] . "</td>";
                                        echo "<td>" . $row['EnrollmentDate'] . "</td>";
                                        echo "<td>";
                                            echo '<a href="student_read.php?id='. $row['ID']   .'">Details</a> | ';
                                            echo '<a href="student_update.php?id='. $row['ID'] .'">Edit</a> | ';
                                            echo '<a href="student_delete.php?id='. $row['ID'] .'">Delete</a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            unset($result);
        } else{
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
} else{
        echo "Oops! Something went wrong. Please try again later.";
}
// Close connection
unset($pdo);
                
?>


<?php
include('footer.php');
?>
</main>
</div>
</html>