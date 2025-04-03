<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

// Fetch departments from the database
$stmt = $pdo->prepare("SELECT DepartmentID, Name FROM Department ORDER BY Name ASC");
$stmt->execute();
$departments = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Define variables and initialize with empty values
$number = $title = $credits = $department = "";
$number_err = $title_err = $credits_err = $department_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate Course Number
    $input_number = trim($_POST["number"]);
    if(empty($input_number)){
        $number_err = "Please enter a course number.";     
    } elseif(!ctype_digit($input_number)){
        $number_err = "Please enter a positive integer value.";
    } else{
        $number = $input_number;
    }
    
    // Validate Course Title
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $title_err = "Please enter a course title.";     
    } else{
        $title = $input_title;
    }

    // Validate Credit Amount
    $input_credits = trim($_POST["credits"]);
    if(empty($input_credits)){
        $credits_err = "Please enter a valid number of credits.";     
    } elseif(!ctype_digit($input_credits) or $input_credits < 1 or $input_credits > 5){
        $credits_err = "Please enter a number between 1 and 5.";
    } else{
        $credits = $input_credits;
    }

    // Validate Department
    $input_department = trim($_POST["department"]);
    if(empty($input_department)){
        $department_err = "Please select a department";     
    } else{
        $department = $input_department;
    }

    // Check input errors before inserting in database
    if(empty($number_err) and empty($title_err) and empty($credits_err) and empty($department_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO Course (CourseID,Title, Credits, DepartmentID) VALUES (:courseid, :title, :credits, :departmentid)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":courseid", $number, PDO::PARAM_INT);
            $stmt->bindParam(":title", $title, PDO::PARAM_STR);
            $stmt->bindParam(":credits", $credits, PDO::PARAM_INT);
            $stmt->bindParam(":departmentid", $department, PDO::PARAM_INT);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: course.php");
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


}

?>

<?php
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Course</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Add Course</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Course Number</label>
                            <input type="text" name="number" class="form-control <?php echo (!empty($number_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $number; ?>">
                            <span class="invalid-feedback"><?php echo $number_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Credits</label>
                            <input type="text" name="credits" class="form-control <?php echo (!empty($credits_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $credits; ?>">
                            <span class="invalid-feedback"><?php echo $credits_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Department</label>
                            <select class="form-control <?php echo (!empty($department_err)) ? 'is-invalid' : ''; ?>" name="department">
                                <option value="">-- Select Department --</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?php echo htmlspecialchars($dept['DepartmentID']); ?>">
                                        <?php echo htmlspecialchars($dept['Name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $department_err;?></span>
                        </div>

                        <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="course.php" class="btn btn-secondary ml-2">Cancel</a>
                        </div>
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