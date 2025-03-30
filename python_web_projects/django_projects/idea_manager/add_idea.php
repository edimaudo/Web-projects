<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/idea.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects
$idea = new Idea($db);
// set page headers

$page_name = "Add idea";
include_once "header.php";
 
// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Ideas</a>";
echo "</div>";
 
?>
<!-- PHP post code will be here -->
<?php 
// if the form was submitted
if($_POST){
 
    // set idea property values
    $idea->name = $_POST['name'];
    $idea->description = $_POST['description'];
 
    // create the idea
    if($idea->create()){
        echo "<div class='alert alert-success'>idea was added.</div>";
    }
 
    // if unable to create the idea, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to add idea.</div>";
    }
}
?>
 
<!-- HTML form for creating a idea -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Description</td>
				<td><textarea name='description' class='form-control'></textarea></td>
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