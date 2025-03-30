<?php
// core.php holds pagination variables
include_once 'config/core.php';
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/movie.php';

 
// instantiate database and movie object
$database = new Database();
$db = $database->getConnection();
 
$movie = new Movie($db);

 
$page_title = "Movies";
include_once "header.php";
 
// query movies
$stmt = $movie->readAll($from_record_num, $records_per_page);
 
// specify the page where paging is used
$page_url = "index.php?";
 
// count total rows - used for pagination
$total_rows=$movie->countAll();
 
// read_template.php controls how the movieing list will be rendered
include_once "read_template.php";
 
// layout_footer.php holds our javascript and closing html tags
include_once "footer.php";
?>