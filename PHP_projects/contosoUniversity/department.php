<?php
include('header.php');
include 'functions.php';
$pdo = pdo_connect_mysql();

?>

<html>
<div class="container">
<main role="main" class="pb-3">
<h2>Department</h2>
<p>
    <a href="department_create.php">Create New</a>
</p>


<?php
try {

        $stmt = $pdo->query("SELECT * FROM Department");
    

    if ($stmt->rowCount() > 0) {
        echo '<table class="table">';
        echo "<thead><tr><th>Name</th><th>Budget</th><th>Start Date</th><th>Instructor</th><th></th></tr></thead><tbody>";
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Name']) . "</td>";
            echo "<td>$" . htmlspecialchars($row['Budget']) . "</td>";
            echo "<td>" . htmlspecialchars( date("Y-m-d",strtotime($row['StartDate']))) . "</td>";
            echo "<td>" . htmlspecialchars( getInstructorName($pdo,$row['InstructorID'])) . "</td>";
            echo "<td>";
            echo '<a href="department_read.php?id=' . $row['DepartmentID'] . '">Details</a> | ';
            echo '<a href="department_update.php?id=' . $row['DepartmentID'] . '">Edit</a> | ';
            echo '<a href="department_delete.php?id=' . $row['DepartmentID'] . '">Delete</a>';
            echo "</td></tr>";
        }
        echo "</tbody></table>";
    } else {
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
    }
} catch (PDOException $e) {
    echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
}

unset($pdo);
?>

<?php
include('footer.php');
?>
</main>
</div>
</html>
