<?php
include('header.php');
?>

<html>
<div class="container">
        <main role="main" class="pb-3">
<h2>Student Body Statistics</h2>
<table class="table">
    <thead>
        <tr>
            <th>Enrollment Date</th>
            <th>Student enrollment Count</th>
        </tr>
    </thead>

<?php
include 'functions.php';
$pdo = pdo_connect_mysql();


$sql = "SELECT EnrollmentDate, Count(*) as Students FROM Student group by EnrollmentDate";

if($result = $pdo->query($sql)){
    
    if($result->rowCount() > 0){
          echo '<tbody>';
          while($row = $result->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . $row['EnrollmentDate'] . "</td>";
                                        echo "<td>" . $row['Students'] . "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            // Free result set
                            unset($result);
        } else {
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
         echo '</tbody>';
} else {
        echo "Oops! Something went wrong. Please try again later.";
}
// Close connection
unset($pdo);

?>

</table>
</main>
</div>
</html>

<?php
include('footer.php');
?>