<?php
// core.php holds pagination variables
include_once 'config/core.php';
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/idea.php';
 
// instantiate database and idea object
$database = new Database();
$db = $database->getConnection();
 
$idea = new Idea($db);
 
// get search term
$search_term=isset($_GET['s']) ? $_GET['s'] : '';
 
$page_title = "You searched for \"{$search_term}\"";
include_once "templates/header.php";
 
// query ideas
$stmt = $idea->search($search_term, $from_record_num, $records_per_page);
 
// specify the page where paging is used
$page_url="search.php?s={$search_term}&";
 
// count total rows - used for pagination
$total_rows=$idea->countAll_BySearch($search_term);
 
// Controls how the idea list will be rendered
include_once "templates/index_search.php";
 
// holds our javascript and closing html tags
include_once "templates/footer.php";
?>