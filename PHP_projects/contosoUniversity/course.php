<?php
include('header.php');
?>

<html>
<div class="container"> 
<main role="main" class="pb-3">
<h2>Courses</h2>

<p> <a href="course_create.php">Create New</a> </p> 

<form action="" method="post">    <p>
Select Department: <select id="SelectedDepartment" name="SelectedDepartment">
<option value="">All</option>
<option value="4">Economics</option>
<option value="3">Engineering</option>
<option value="1">English</option>
<option value="2">Mathematics</option>
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

$sql = "SELECT * FROM Course";
if($result = $pdo->query($sql)){
    if($result->rowCount() > 0){
        echo '<table class="table"> ';
        echo "<thead>";
        echo "<tr>";
        echo "<th> Number </th>";
        echo "<th> Title </th>";
        echo "<th> Credits </th>";
        echo "<th> Department </th>";
        echo "<th></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        while($row = $result->fetch()){
                                    echo "<tr>";
                                        
                                        echo "<td>" . $row['CourseID'] . "</td>";
                                        echo "<td>" . $row['Title'] . "</td>";
                                        echo "<td>" . $row['Credit'] . "</td>";
                                        //echo "<td>" . getDepartmentName(,$pdo,$row['DepartmentID']) . "</td>";
                                        echo "<td>";
                                            echo '<a href="read.php?id='. $row['id'] .'" class="mr-3" title="Details" data-toggle="tooltip">|';
                                            echo '<a href="update.php?id='. $row['id'] .'" class="mr-3" title="Edit" data-toggle="tooltip"></a>|';
                                            echo '<a href="delete.php?id='. $row['id'] .'" title="Delete" data-toggle="tooltip"></a>';
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
                    } else{
                        echo "Oops! Something went wrong. Please try again later.";
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