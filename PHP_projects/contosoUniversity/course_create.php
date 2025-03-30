<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

?>

<?php
include('header.php');
?>

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
                <span class="text-danger field-validation-valid" data-valmsg-for="DepartmentID" data-valmsg-replace="true">
            </span></div>
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