<?php 
$id =  $_GET['id'];
if (isset($_GET['id'])){
    // include database and object files
    include_once 'config/database.php';
    include_once 'objects/idea.php';

     
    // get database connection
    $database = new Database();
    $db = $database->getConnection();
    $name_err = $description_err = "";
     
    // prepare objects
    $idea = new Idea($db);

    // set ID property of ideaing to be edited
    $idea->id = $_GET['id'];//$id;
     
    // read the details of idea to be edited
    $idea->readOne();

    // set page header
    $page_title = "Update idea"; //fix to $page_name
    include_once "templates/header.php";


    // contents will be here
    echo "<div class='right-button-margin'>";
        echo "<a href='index.php' class='btn btn-default pull-right'>Ideas</a>";
    echo "</div>";


    if($_POST){

        // set idea property values
        $idea->name = $_POST['name'];
        $idea->description = $_POST['description'];

        // Validate name
        $input_name = trim($_POST["name"]);
        if(empty($input_name)){
            $name_err = "Please enter a name.";
        } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
            $name_err = "Please enter a idea name.";
        } else{
            $idea->name  = $input_name;
        }
        
        // Validate description
        $input_description = trim($_POST["description"]);
        if(empty($input_description)){
            $description_err = "Please enter an  idea description.";     
        } else{
            $idea->description = $input_description;
        }


             // Check input errors before inserting in database
            if(empty($name_err) && empty($description_err)){

                    // Attempt to execute the prepared statement
                    if($idea->update()){
                        echo "<div class='alert alert-success alert-dismissable'>";
                            echo "idea was updated.";
                        echo "</div>";
                        sleep(0.8);
                        // Records created successfully. Redirect to landing page
                        header("location: index.php");
                        exit();
                    } else{
                        echo "<div class='alert alert-danger alert-dismissable'>";
                            echo "Unable to update idea.";
                        echo "</div>";
                    }

            }

    }

} else {
    // URL doesn't contain valid id. Redirect to error page
    header("location: error.php");
    exit();
}

 ?>


<!-- HTML form for creating a idea -->
<div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $idea->name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control <?php echo (!empty($description_err)) ? 'is-invalid' : ''; ?>"><?php echo $idea->description; ?></textarea>
                            <span class="invalid-feedback"><?php echo $description_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Update">
                    </form>

                </div>
            </div>        
        </div>
    </div>

<?php 
// footer
include_once "templates/footer.php";
?>