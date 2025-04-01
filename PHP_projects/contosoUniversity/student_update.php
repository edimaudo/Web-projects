<?php
include('header.php');
?>

<?php
// Include config file
include 'functions.php';
$pdo = pdo_connect_mysql();
 
// Define variables and initialize with empty values
$first_name = $last_name = $enrollment_date = "";
$first_name_err = $last_name_err = $enrollment_date_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    
    // Validate first name
    $input_first_name = trim($_POST["first_name"]);
    if(empty($input_first_name)){
        $first_name_err = "First Name cannot be empty";     
    } elseif (strlen($input_first_name) > 50) {
        $first_name_err = "First name cannot be longer than 50 characters";  
    } else {
        $first_name = $input_first_name;
    }


    // Validate last name
    $input_last_name = trim($_POST["last_name"]);
    if(empty($input_last_name)){
        $last_name_err = "Last Name cannot be empty";     
    } elseif (strlen($input_last_name) > 50) {
        $last_name_err = "Last name cannot be longer than 50 characters";  
    } else {
        $last_name = $input_last_name;
    }
    
    // Validate Enrollment date
    $input_enrollment_date = trim($_POST["enrollment_date"]);
    if(empty($input_enrollment_date)){
        $enrollment_date_err = "Enrollment date cannot be empty";     
    }  else {
        $enrollment_date =  $input_enrollment_date;
    } 

    
    // Check input errors before inserting in database
    if(empty($first_name_err) && empty($last_name_err) && empty($enrollment_date_err)){
        // Prepare an update statement
        $sql = "UPDATE Student SET FirstName=:FirstName, LastName=:LastName, EnrollmentDate=:EnrollmentDate WHERE id=:id";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":FirstName", $param_first_name);
            $stmt->bindParam(":LastName", $param_last_name);
            $stmt->bindParam(":EnrollmentDate", $param_enrollment_date);
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_first_name = $first_name;
            $param_last_name = $last_name;
            $param_enrollment_date = $enrollment_date;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records updated successfully. Redirect to landing page
                header("location: student.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM Student WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
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
                    // URL doesn't contain valid id. Redirect to error page
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
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Student Record</h2>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group">
                            <label><b>First Name</b></label>
                            <input type="text" name="first_name" class="form-control <?php echo (!empty($first_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $first_name; ?>">
                            <span class="invalid-feedback"><?php echo $first_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label><b>Last Name</b></label>
                            <input type="text" name="last_name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                            <span class="invalid-feedback"><?php echo $last_name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label><b>Enrollment Date</b></label>
            <input type="date" name="enrollment_date" class="form-control <?php echo (!empty($enrollment_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $enrollment_date; ?>">
                            <span class="invalid-feedback"><?php echo $enrollment_date_err;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="student.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>


<?php
include('footer.php');
?>