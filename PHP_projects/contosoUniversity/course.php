<?php
include('header.php');
?>

<html>
<div class="container"> 
<main role="main" class="pb-3">
<h2>Courses</h2>

<p> <a href="course_create.php">Create New</a> </p> 

<form action="" method="post">    
    <p>
        Select Department: 
        <select id="SelectedDepartment" name="SelectedDepartment">
            <option value="">All</option>
            <option value="4" <?php if(isset($_POST['SelectedDepartment']) && $_POST['SelectedDepartment'] == '4') echo 'selected'; ?>>Economics</option>
            <option value="3" <?php if(isset($_POST['SelectedDepartment']) && $_POST['SelectedDepartment'] == '3') echo 'selected'; ?>>Engineering</option>
            <option value="1" <?php if(isset($_POST['SelectedDepartment']) && $_POST['SelectedDepartment'] == '1') echo 'selected'; ?>>English</option>
            <option value="2" <?php if(isset($_POST['SelectedDepartment']) && $_POST['SelectedDepartment'] == '2') echo 'selected'; ?>>Mathematics</option>
        </select>
        <input type="submit" value="Filter">
    </p>
    <input name="_" type="hidden" value="">
</form>

<?php
include 'functions.php';
$pdo = pdo_connect_mysql();


function getDepartmentName($pdo, $departmentId) {
    $sql = "SELECT Name FROM Department WHERE DepartmentID = :departmentId";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':departmentId', $departmentId, PDO::PARAM_INT);
    $stmt->execute();
    
    $department = $stmt->fetch(PDO::FETCH_ASSOC);
    return $department ? $department['Name'] : null;
}


$selectedDepartment = isset($_POST['SelectedDepartment']) ? $_POST['SelectedDepartment'] : '';
$sql = "SELECT * FROM Course";

if (!empty($selectedDepartment)) {
    $sql .= " WHERE DepartmentID = :departmentId";
}

$stmt = $pdo->prepare($sql);

if (!empty($selectedDepartment)) {
    $stmt->bindParam(':departmentId', $selectedDepartment, PDO::PARAM_INT);
}
$stmt->execute();


    if($stmt->rowCount() > 0){
        echo '<table class="table"><thead><tr><th> Number </th><th> Title </th><th> Credits </th><th> Department </th><th></th></tr></thead><tbody>';
        while($row = $stmt->fetch()){
                                    echo "<tr>";
                                        echo "<td>" . htmlspecialchars($row['CourseID']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Title']) . "</td>";
                                        echo "<td>" . htmlspecialchars($row['Credits']) . "</td>";
                                        echo "<td>" . htmlspecialchars(getDepartmentName($pdo,$row['DepartmentID'])) . "</td>";
                                        echo "<td>";
                                            echo '<a href="course_read.php?id='. $row['CourseID'] .'"">Read</a> | ';
                                            echo '<a href="course_update.php?id='. $row['CourseID'] .'"">Edit</a> | ';
                                            echo '<a href="course_delete.php?id='. $row['CourseID'] .'"">Delete</a>';
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
                    
                    // Close connection
                    unset($pdo);
                
?>
</main> 
</div>

	


<?php
include('footer.php');
?>

      
</html>