<?php
// retrieve one ideaing will be here
// get ID of the ideaing to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/idea.php';

 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$idea = new Idea($db);

// set ID property of ideaing to be edited
$idea->id = $id;
 
// read the details of idea to be edited
$idea->readOne();

// set page header
$page_title = "Update idea"; //fix to $page_name
include_once "header.php";


// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Ideas</a>";
echo "</div>";
?>


<!-- 'update idea' form will be here -->

<!-- post code will be here -->
<?php 
// if the form was submitted
if($_POST){
 
    // set idea property values
    $idea->name = $_POST['name'];
    $idea->description = $_POST['description'];
 
    // update the idea
    if($idea->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "idea was updated.";
        echo "</div>";
    }
 
    // if unable to update the idea, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update idea.";
        echo "</div>";
    }
}
?>

 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>name</td>
            <td><input type='text' name='name' value='<?php echo $idea->name; ?>' class='form-control' /></td>
        </tr>
 

 
        <tr>
            <td>description</td>
            <td><textarea name='description' class='form-control'><?php echo $idea->description; ?></textarea></td>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">Update</button>
            </td>
        </tr>
 
    </table>
</form>

<?php 

 

 
// set page footer
include_once "footer.php";
?>