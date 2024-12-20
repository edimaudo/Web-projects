<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/contact.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects
$contact = new Contact($db);
$name_err = "";
// set page headers

$page_title = "Add Contact";
include_once "templates/header.php";
 
// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Contacts</a>";
echo "</div>";
 

// if the form was submitted
if($_POST){
    

    // set contacting property values
    $contact->name = $_POST['name'];
    $contact->phone_number = $_POST['phone_number'];
    $contact->email = $_POST['email'];

    // Validate name
    
    if(empty($contact->name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($contact->name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } 
    


    // create the contact
    if(!empty($contact->name)){
        
        if ($contact->create()){
            echo "<div class='alert alert-success'>Contact was added.</div>";
            header("location: index.php");
                exit();
        }
        

    }
 
    // if unable to create the contact, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to add new Contact.</div>";
    }
}
?>
 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $contact->name; ?>"></td>
            <span class="invalid-feedback"><?php echo $name_err;?></span>
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
                <button type="submit" class="btn btn-primary">Create Contact</button>
            </td>
        </tr>
 
    </table>
</form>
<?php 
// footer
include_once "templates/footer.php";
?>