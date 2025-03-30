<?php
// retrieve one genre will be here
// get ID of the genre to be edited
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/movie.php';

 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare objects
$movie = new Movie($db);
 
// set ID property of genre to be edited
$movie->id = $id;
 
// read the details of movie to be edited
$movie->readOne();

// set page header
$page_title = "Update movie";
include_once "header.php";


// contents will be here
echo "<div class='right-button-margin'>";
    echo "<a href='index.php' class='btn btn-default pull-right'>Movies</a>";
echo "</div>";
?>


<!-- 'update movie' form will be here -->

<!-- post code will be here -->
<?php 
// if the form was submitted
if($_POST){
    function validateDate($date, $format = 'Y-m-d'){
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
    }
    // set movie property values
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



    // update the movie
    if(empty($name_err) && empty($price_err) && empty($genre_err) && empty($date_err)){
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update movie.";
        echo "</div>";
    }
    elseif($movie->update()){
        echo "<div class='alert alert-success alert-dismissable'>";
            echo "movie was updated.";
        echo "</div>";
    }
 
    // if unable to update the movie, tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update movie.";
        echo "</div>";
    }
}
?>

 
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post">
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>Title</td>
            <td><input type='text' name='title' value='<?php echo $movie->title; ?>' class='form-control' required/></td>
        </tr>
 
        <tr>
            <td>Release Date</td>
            <td><input type='date' name='release_date' value='<?php echo $movie->release_date; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>Genre</td>
            <td><input type="text" name='genre' value='<?php echo $movie->genre; ?>'class='form-control'/> </td>
        </tr>
 
        <tr>
            <td>Price</td>
            <td><input type="number" step="0.01" min="0" name='price' value='<?php echo $movie->price; ?>'class='form-control'/> </td>
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