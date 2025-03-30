<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/learn.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects
$learn = new Learn($db);
// set page headers

$page_title = "Add learning";
include_once "header.php";
 
// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Read learning</a>";
echo "</div>";
 
?>
<!-- PHP post code will be here -->
<?php 
// if the form was submitted
if($_POST){
 
    // set learning property values
    $learn->title = $_POST['title'];
    $learn->time_spent = $_POST['time_spent'];
    $learn->learning = $_POST['learning'];
    $learn->resources = $_POST['resources'];
 
    // create the learning
    if($learn->create()){
        echo "<div class='alert alert-success'>learning was added.</div>";
    }
 
    // if unable to create the learning, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to add learning.</div>";
    }
}
?>
 
<!-- HTML form for creating a learning -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Title</td>
            <td><input type='text' name='title' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Time spent</td>
            <td><input type='text' name='time_spent' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Learning</td>
            <td><textarea name='learning' class='form-control'></textarea></td>
        </tr>
 
        <tr>
            <td>Resources</td>
				<td><textarea name='resources' class='form-control'></textarea></td>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Create</button>
            </td>
        </tr>
 
    </table>
</form>
<?php 
// footer
include_once "footer.php";
?>