<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

// Fetch departments from the database
$stmt = $pdo->prepare("SELECT ID, CONCAT(LastName, ', ' , FirstName) as Name FROM Instructor ORDER BY Name ASC");
$stmt->execute();
$instructors = $stmt->fetchAll(PDO::FETCH_ASSOC);


// Define variables and initialize with empty values
$dept_id = $name = $budget = $start_date = $instructor = "";
$dept_id_err = $name_err = $budget_err = $start_date_err = $instructor_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate Department ID
    $input_dept_id = trim($_POST["dept_id"]);
    if(empty($input_dept_id)){
        $dept_id_err = "Please enter a department number.";     
    } elseif(!ctype_digit($input_budget) or $input_budget < 1){
        $dept_id_err = "Please enter a a valid number or a number greater than 0";
    } else{
        $dept_id = $input_dept_id;
    }

    // Validate Dept. Name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a Dept. Name.";     
    }  else{
        $name = $input_name;
    }

    // Validate Budget
    $input_budget = trim($_POST["budget"]);
    if(empty($input_budget)){
        $budget_err = "Please enter a budget.";     
    } elseif(!ctype_digit($input_budget) or $input_budget < 1){
        $budget_err = "Please enter a a valid number or a number greater than 0";
    } else{
        $budget = $input_budget;
    }
    
    // Validate Start Date
    $input_start_date = trim($_POST["start_date"]);
    if(empty($input_start_date)){
        $start_date_err = "Please enter a date.";     
    } else{
        $start_date = $input_start_date;
    }



    // Validate Instructor
    $input_instructor = trim($_POST["instructor"]);
    if(empty($input_instructor)){
        $instructor_err = "Please select an instructor";     
    } else{
        $instructor = $input_instructor;
    }

    // Check input errors before inserting in database
    if(empty($dept_id_err) and empty($name_err) and empty($budget_err) and empty($start_date_err) and empty($instructor_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO Department (DepartmentID, Name,Budget, StartDate, InstructorID) VALUES (:deptid, :name, :budget, :startdate, :instructorid)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":deptid", $dept_id, PDO::PARAM_INT);
            $stmt->bindParam(":name", $name, PDO::PARAM_STR);
            $stmt->bindParam(":budget", $budget);
            $stmt->bindParam(":startdate", $start_date);
            $stmt->bindParam(":instructorid", $instructor, PDO::PARAM_INT);
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: department.php");
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
                    <h2 class="mt-5">Add Department</h2>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Department Number</label>
                            <input type="text" name="dept_id" class="form-control <?php echo (!empty($dept_id_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $dept_id; ?>">
                            <span class="invalid-feedback"><?php echo $dept_id_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Budget</label>
                            <input type="text" name="budget" class="form-control <?php echo (!empty($budget_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $budget; ?>">
                            <span class="invalid-feedback"><?php echo $budget_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Start Date</label>
                            <input type="date" name="start_date" class="form-control <?php echo (!empty($start_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $start_date; ?>">
                            <span class="invalid-feedback"><?php echo $start_date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Instructors</label>
                            <select class="form-control <?php echo (!empty($instructor_err)) ? 'is-invalid' : ''; ?>" name="instructor">
                                <option value="">-- Select Instructor --</option>
                                <?php foreach ($instructors as $instructor): ?>
                                    <option value="<?php echo htmlspecialchars($instructor['ID']); ?>">
                                        <?php echo htmlspecialchars($instructor['Name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="invalid-feedback"><?php echo $instructor_err;?></span>
                        </div>

                        <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="department.php" class="btn btn-secondary ml-2">Cancel</a>
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