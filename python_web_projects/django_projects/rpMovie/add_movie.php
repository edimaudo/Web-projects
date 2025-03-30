<?php
// include database and object files
include_once 'config/database.php';
include_once 'objects/movie.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// pass connection to objects
$movie = new Movie($db);
// set page headers

$page_title = "Add movie";
include_once "header.php";
 
// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Movies</a>";
echo "</div>";
 
?>
<!-- PHP post code will be here -->
<?php 

function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}
// if the form was submitted
if($_POST){
        #$movie->title = $_POST['title'];
    #$movie->release_date = $_POST['release_date'];
    #$movie->genre = $_POST['genre'];
    #$movie->price = $_POST['price'];
    $date_err = $price_err = $name_err = $genre_err = "";
   
    // set genre property values
    if (!filter_var($_POST['title'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/"))))
    {
        $name_err = "Please enter a valid name.";
    }
    else 
    {
        $movie->title = $_POST['title'];
    }
    
   
    if (!validateDate($_POST['release_date'])){
        $date_err = "Please enter a valid date.";
    }
    else {
        $movie->release_date = $_POST['release_date'];
    }
      
    if (!filter_var($_POST['genre'], FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $genre_err = "Please enter a valid genre.";
    }
    else {
        $movie->genre = $_POST['genre'];
    }

   
     if (!is_numeric($_POST['price'])){
        $price_err = "Please enter a valid price.";
    } elseif ($price < 0) {
        $price_err = "Please enter a valid price.";
    }
    else {
        $movie->price = $_POST['price'];
    }

    if(empty($name_err) && empty($price_err) && empty($genre_err)){
        echo "<div class='alert alert-danger'>Unable to add movie.</div>";
    }
    // create the movie
    elseif($movie->create()){
        echo "<div class='alert alert-success'>movie was added.</div>";
    }
 
    // if unable to create the movie, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to add movie.</div>";
    }
}
?>
 
<!-- HTML form for creating a genre -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
 
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Title</td>
            <td><input type='text' name='title' class='form-control' required /></td>
        </tr>
 
        <tr>
            <td>Release Date</td>
            <td><input type='date' name='release_date' class='form-control' required/></td>
        </tr>
 
        <tr>
            <td>genre</td>
            <td><input type='text' name='genre' class='form-control' required/></td>
        </tr>
 
        <tr>
            <td>price</td>
				<td><input step="0.01" min="0" type="number" name='price' class='form-control' required /></td>
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