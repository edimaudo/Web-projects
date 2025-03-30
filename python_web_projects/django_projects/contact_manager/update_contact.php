<?php
// retrieve one contacting will be here
// get ID of the contacting to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/contact.php';

 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$contact = new Contact($db);
 
// set ID property of contacting to be edited
$contact->id = $id;
 
// read the details of contact to be edited
$contact->readOne();

// set page header
$page_title = "Update contact";
include_once "header.php";


// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Contacts</a>";
echo "</div>";
?>


<!-- 'update contact' form will be here -->

<!-- post code will be here -->
<?php 
// if the form was submitted
if($_POST){
 
    // set contact property values
    $contact->name = $_POST['name'];
    $contact->phone_number = $_POST['phone_number'];
    $contact->email = $_POST['email'];
 
    // update the contact
    if($contact->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "contact was updated.";
        echo "</div>";
    }
 
    // if unable to update the contact, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update contact.";
        echo "</div>";
    }
}
?>

 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>name</td>
            <td><input type='text' name='name' value='<?php echo $contact->name; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Phone Number</td>
            <td><input type='tel' name='phone_number' value='<?php echo $contact->phone_number; ?>' class='form-control' /></td>
        </tr>
 
 
        <tr>
            <td>email</td>
            <td><input type='email' name='email' value='<?php echo $contact->email; ?>' class='form-control' /></td>
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