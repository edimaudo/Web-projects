<?php
include 'functions.php';
$pdo = pdo_connect_mysql();

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
    $input_credits = trim($_POST["number"]);
    if(empty($input_credits)){
        $credits_err = "Please enter a valid number of credits.";     
    } elseif(!ctype_digit($input_credits)){
        $credits_err = "Please enter a number between 0 and 5";
    } elseif(ctype_digit($input_credits) > 4 or ctype_digit($input_credits) < 1){
        $credits_err = "Credits should be between 0 and 5";
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
    if(empty($number_err) && empty($title_err) && empty($credits_err) && empty($department_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO employees (name, address, salary) VALUES (:name, :address, :salary)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":name", $param_name);
            $stmt->bindParam(":address", $param_address);
            $stmt->bindParam(":salary", $param_salary);
            
            // Set parameters
            $param_name = $name;
            $param_address = $address;
            $param_salary = $salary;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
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
    <title>Create Record</title>
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
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Salary</label>
                            <input type="text" name="salary" class="form-control <?php echo (!empty($salary_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $salary; ?>">
                            <span class="invalid-feedback"><?php echo $salary_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
<div class="container">
        <main role="main" class="pb-3">
<h1>Add Course</h1>
<hr>
<div class="row">
<div class="col-md-4">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            
            <div class="form-group">
                <label class="control-label" for="CourseID">Number</label>
                <input class="form-control" type="number" data-val="true" data-val-required="The Number field is required." id="CourseID" name="CourseID" value="">
                <span class="text-danger field-validation-valid" data-valmsg-for="CourseID" data-valmsg-replace="true"></span>
            </div>

            <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>

            <div class="form-group">
                <label class="control-label" for="Title">Title</label>
                <input class="form-control" type="text" data-val="true" data-val-length="The field Title must be a string with a minimum length of 3 and a maximum length of 50." data-val-length-max="50" data-val-length-min="3" id="Title" maxlength="50" name="Title" value="">
                <span class="text-danger field-validation-valid" data-valmsg-for="Title" data-valmsg-replace="true"></span>
            </div>
            <div class="form-group">
                <label class="control-label" for="Credits">Credits</label>
                <input class="form-control" type="number" data-val="true" data-val-range="The field Credits must be between 0 and 5." data-val-range-max="5" data-val-range-min="0" data-val-required="The Credits field is required." id="Credits" name="Credits" value="">
                <span class="text-danger field-validation-valid" data-valmsg-for="Credits" data-valmsg-replace="true"></span>
            </div>
            
            <div class="form-group">
                <label class="control-label" for="Department">Department</label>
                <select class="form-control" data-val="true" data-val-required="The DepartmentID field is required." id="DepartmentID" name="DepartmentID">
                    <option value="">-- Select Department --</option>
                <option value="4">Economics</option>
                    <option value="3">Engineering</option>
                    <option value="1">English</option>
                    <option value="2">Mathematics</option>
                    </select>
                </div>
            <div class="form-group">
                <input type="submit" value="Create" class="btn btn-primary">
            </div>
        </form>
    </div>
</div>

<div>
    <a href="course.php">Back to List</a>
</div>
<?php
include('footer.php');
?>