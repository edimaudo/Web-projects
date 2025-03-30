<?php
// retrieve one learning will be here
// get ID of the learning to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/learn.php';

 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$learn = new Learn($db);
 
// set ID property of learning to be edited
$learn->id = $id;
 
// read the details of learn to be edited
$learn->readOne();

// set page header
$page_title = "Update Learning";
include_once "header.php";


// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Read Learning</a>";
echo "</div>";
?>


<!-- 'update learn' form will be here -->

<!-- post code will be here -->
<?php 
// if the form was submitted
if($_POST){
 
    // set learn property values
    $learn->title = $_POST['title'];
    $learn->time_spent = $_POST['time_spent'];
    $learn->learning = $_POST['learning'];
    $learn->resources = $_POST['resources'];
 
    // update the learn
    if($learn->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "learning was updated.";
        echo "</div>";
    }
 
    // if unable to update the learn, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update learning.";
        echo "</div>";
    }
}
?>

 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Title</td>
            <td><input type='text' name='title' value='<?php echo $learn->title; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Time spent</td>
            <td><input type='text' name='time_spent' value='<?php echo $learn->time_spent; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Learning</td>
            <td><textarea name='learning' class='form-control'><?php echo $learn->learning; ?></textarea></td>
        </tr>
 
        <tr>
            <td>Resources</td>
            <td><textarea name='resources' class='form-control'><?php echo $learn->resources; ?></textarea></td>
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