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

 
$page_title = "Ideas";
include_once "header.php";
 
// query ideas
$stmt = $idea->readAll($from_record_num, $records_per_page);
 
// specify the page where paging is used
$page_url = "index.php?";
 
// count total rows - used for pagination
$total_rows=$idea->countAll();
 
// read_template.php controls how the ideaing list will be rendered
include_once "read_template.php";
 
// layout_footer.php holds our javascript and closing html tags
include_once "footer.php";
?>