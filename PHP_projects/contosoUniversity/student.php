<?php
include('header.php');
include 'functions.php';
$pdo = pdo_connect_mysql();
$search = "";

?>

<html>
<div class="container">
<main role="main" class="pb-3">
<h2>Students</h2>
<p>
    <a href="student_create.php">Create New</a>
</p>

<form method="POST" action="">
    <div class="form-actions no-color">
        <p>
            Find by name: <input type='text' name='search' value="<?php echo htmlspecialchars($search); ?>" placeholder='Enter first or last name'>
            <input type="submit" value="Search" id="SearchButton" class="btn btn-default"> | 
            <a href="student.php">Back to Full List</a>
        </p>
    </div>
</form>

<?php
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search'])) {
        $search = trim($_POST['search']) ?? '';
        if (!empty($search)) {
            $sql = "SELECT * FROM Student WHERE FirstName LIKE :search OR LastName LIKE :search";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['search' => "%$search%"]);
        } else {
            $stmt = $pdo->query("SELECT * FROM Student");
        }
    } else {
        $stmt = $pdo->query("SELECT * FROM Student");
    }

    if ($stmt->rowCount() > 0) {
        echo '<table class="table">';
        echo "<thead><tr><th>Last Name</th><th>First Name</th><th>Enrollment Date</th><th></th></tr></thead><tbody>";
        while ($row = $stmt->fetch()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['LastName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['FirstName']) . "</td>";
            echo "<td>" . htmlspecialchars($row['EnrollmentDate']) . "</td>";
            echo "<td>";
            echo '<a href="student_read.php?id=' . $row['ID'] . '">Details</a> | ';
            echo '<a href="student_update.php?id=' . $row['ID'] . '">Edit</a> | ';
            echo '<a href="student_delete.php?id=' . $row['ID'] . '">Delete</a>';
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
