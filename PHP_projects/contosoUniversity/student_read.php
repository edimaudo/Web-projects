<?php
include('header.php');
?>

<?php
// Check existence of id parameter before processing further
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    include 'functions.php';
    $pdo = pdo_connect_mysql();
    
    // Prepare a select statement
    $sql = "SELECT * FROM Student WHERE id = :id";
    
    if($stmt = $pdo->prepare($sql)){
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":id", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if($stmt->execute()){
            if($stmt->rowCount() == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                // Retrieve individual field value
                $first_name = $row["FirstName"];
                $last_name = $row["LastName"];
                $enrollment_date = $row["EnrollmentDate"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
    // Close statement
    unset($stmt);
    
    // Close connection
    unset($pdo);
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>


<div class="container">
        <main role="main" class="pb-3">
<h1>Student Details</h1>

<div>
    <hr>
    <dl class="row">
        <dt class="col-sm-2">
            Last Name
        </dt>
        <dd class="col-sm-10">
            <?php echo htmlspecialchars($row["LastName"]); ?>
            
        </dd>
        <dt class="col-sm-2">
            First Name
        </dt>
        <dd class="col-sm-10">
            <?php echo htmlspecialchars($row["FirstName"]); ?>
        </dd>
        <dt class="col-sm-2">
            Enrollment Date
        </dt>
        <dd class="col-sm-10">
            <?php echo htmlspecialchars($row["EnrollmentDate"]); ?>
        </dd>
        
            </tbody></table>
        </dd>
    </dl>
</div>
<div>
    <a href="student_update.php?id='. $row['ID']   .'">Edit</a> |
    <a href="student.php">Back to List</a>
</div>

        </main>
    </div>

<?php
include('footer.php');
?>