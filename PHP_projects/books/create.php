<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$title = $publication_date = $author = $price = $pages = $book_type = "";
$title_err = $publication_date_err = $author_err = $price_err = $pages_err = $book_type_error = "";


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
        $title_err = "Please enter a valid book title.";
    } else{
        $title = $input_title;
    }

    // Validate Publication Date
    $input_publication_date = trim($_POST["publication_date"]);
    if (!is_valid_Date(input_publication_date)) {
        $publication_date_err = "Please enter a valid date.";
    } elseif(input_publication_date > date("Y/m/d")){
        $publication_date_err = "The date can't be in the future.";
    }

    else {
        $publication_date = $publication_date;
    }

    // Validate Author
    $input_author = trim($_POST["author"]);
    if(empty($input_author)){
        $author_err = "Please enter a value.";
    } elseif(!filter_var($input_author, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $author_err = "Please enter a valid Author.";
    } else{
        $author = $input_author;
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

    // Validate pages
    $input_pages = trim($_POST["pages"]);
    if(empty($input_pages)){
        $pages_err = "Please enter the # of pages.";     
    } elseif(!ctype_digit($input_pages)){
        $pages_err = "Please enter a positive value.";
    } else{
        $pages = $input_pages;
    }


    // Validate Book Type
    $book_type_list = array('Hardcover', 'Paperback', 'E-book');
    $input_book_type = trim($_POST["book_type"]);
    if(empty($input_book_type)){
        $book_type_err = "Please enter a valid book type";  
    }
    elseif(!in_array(input_book_type, $book_type_list)){
        $pages_err = "Please enter a positive value.";
    } else{
        $book_type = $input_book_type;
    }
    

    

    // Check input errors before inserting in database
    if(empty($title_err) && empty($publication_date_err) && empty($price_err) && empty($author_err) && empty($pages_err) && empty($book_type_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO Book (title, publication_date, author, price, pages, book_type) VALUES (:title, :publication_date, :author, :price, :pages, :book_type)";
 
        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":title", $param_title);
            $stmt->bindParam(":publication_date", $param_publication_date);
            $stmt->bindParam(":author", $param_author);
            $stmt->bindParam(":price", $param_price);
            $stmt->bindParam(":pages", $param_pages);
            $stmt->bindParam(":book_type", $param_book_type);
            
            // Set parameters
            $param_title = $title;
            $param_publication_date = $publication_date;
            $param_author = $author;
             $param_price = $price;
            $param_pages = $pages;
            $param_book_type = $book_type;

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
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                    <h2 class="mt-5">Add Book</h2>
                    <p>Please fill this form and submit to add a Book.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Title</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($title_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $title; ?>">
                            <span class="invalid-feedback"><?php echo $title_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Published Date</label>
                            <input type="date" name="published_date" class="form-control <?php echo (!empty($published_date_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $published_date; ?>">
                            <span class="invalid-feedback"><?php echo $published_date_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control <?php echo (!empty($price_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $price; ?>">
                            <span class="invalid-feedback"><?php echo $price_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Author</label>
                            <input type="text" name="title" class="form-control <?php echo (!empty($author_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $author; ?>">
                            <span class="invalid-feedback"><?php echo $author_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Pages</label>
                            <input type="number" name="pages" class="form-control <?php echo (!empty($pages_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $pages; ?>">
                            <span class="invalid-feedback"><?php echo $pages_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Book Types</label>
                              <select id="book_type" name="book_type" class="form-control <?php echo (!empty($book_type_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $book_type; ?>">
                                  <option value="Hardcover">Hardcover</option>
                                  <option value="Paperback">Paperback</option>
                                  <option value="E-book">E-book</option>
                              </select>
                            <span class="invalid-feedback"><?php echo $book_type_err;?></span>
                        </div>


                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="index.php" class="btn btn-secondary ml-2">Go Back to Book List</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>