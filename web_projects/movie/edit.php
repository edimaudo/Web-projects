<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$title = $release_date = $genre = $price  = "";
$title_err = $release_date_err = $genre_err = $price_err = "";


function is_valid_Date($date) {
    list($year, $month, $day) = explode('-', $date);
    return checkdate($month, $day, $year);
}
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate Title
    $input_title = trim($_POST["title"]);
    if(empty($input_title)){
        $name_err = "Please enter a title.";
    } elseif(!filter_var($input_title, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $title_err = "Please enter a valid movie title.";
    } else{
        $title = $input_title;
    }

    // Validate Release Date
    $input_release_date = trim($_POST["release_date"]);
    if (!is_valid_Date(input_release_date)) {
        $release_date_err = "Please enter a valid date.";
    } else {
        $release_date = $release_date;
    }

    // Validate genre
    $input_genre = trim($_POST["genre"]);
    if(empty($input_genre)){
        $genre_err = "Please enter a value.";
    } elseif(!filter_var($input_genre, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $genre_err = "Please enter a valid genre.";
    } else{
        $genre = $input_genre;
    }    


    // Validate price
    $input_price = trim($_POST["price"]);
    if(empty($input_price)){
        $price_err = "Please enter the price amount.";     
    } elseif(!is_numeric($input_price)){
        $price_err = "Please enter a valid price value.";
    } else{
        $price = $input_price;
    }
    

    

    // Check input errors before inserting in database
    if(empty($title_err) && empty($release_date_err) && empty($price_err) && empty($genre_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO Movie (title, release_date, genre, price) VALUES (:title, :release_date, :genre, :price)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":title", $param_title);
            $stmt->bindParam(":release_date", $param_release_date);
            $stmt->bindParam(":genre", $param_genre);
            $stmt->bindParam(":price", $param_price);
            
            // Set parameters
            $param_title = $title;
            $param_release_date = $release_date;
            $param_genre = $genre;
            $param_price = $price;


            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        unset($stmt);
    }
    
    // Close connection
    unset($pdo);
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM Movie WHERE id = :id";
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":id", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                
                    // Retrieve individual field value
                    $title = $row["title"];
                    $release_date = $row["release_date"];
                    $price = $row["price"];
                    $genre = $row["genre"];

                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        unset($stmt);
        
        // Close connection
        unset($pdo);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Update Movie</h2>
                    <p>Please fill this form and submit to Update a movie.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Release Date</label>
                            <input type="date" name="published_date" class="form-control <?php echo (!empty($release_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $release_date; ?>">
                            <span class="invalid-feedback"><?php echo $release_date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>genre</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($genre_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $genre; ?>">
                            <span class="invalid-feedback"><?php echo $genre_err;?></span>
                        </div>


                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Go Back to Movie List</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
      <footer class="border-top footer text-muted">
        <div class="container">
            &copy;  <a href="index.php" class="btn btn-secondary ml-2">Movie</a>
        </div>
    </footer>
</body>
</html