<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/contact.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects
$learn = new Contact($db);
// set page headers

$page_title = "Add Contact";
include_once "header.php";
 
// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Contacts</a>";
echo "</div>";
 
?>
<!-- PHP post code will be here -->
<?php 
// if the form was submitted
if($_POST){
 
    // set learning property values
    $learn->name = $_POST['name'];
    $learn->phone_number = $_POST['phone_number'];
    $learn->email = $_POST['email'];
 
    // create the learning
    if($learn->create()){
        echo "<div class='alert alert-success'>Contact was added.</div>";
    }
 
    // if unable to create the learning, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to add Contact.</div>";
    }
}
?>
 
<!-- HTML form for creating a learning -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Name</td>
            <td><input type='text' name='name' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Phone number</td>
            <td><input type='tel' name='phone_number' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>email</td>
				<td><input type ='email' name='email' class='form-control' /></td>
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