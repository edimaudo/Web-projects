<?php
// core.php holds pagination variables
include_once 'config/core.php';
 
// include database and object files
include_once 'config/database.php';
include_once 'objects/contact.php';

 
// instantiate database and contact object
$database = new Database();
$db = $database->getConnection();
 
$contact = new Contact($db);

 
$page_title = "Contacts";
include_once "header.php";
 
// query contacts
$stmt = $contact->readAll($from_record_num, $records_per_page);
 
// specify the page where paging is used
$page_url = "index.php?";
 
// count total rows - used for pagination
$total_rows=$contact->countAll();
 
// read_template.php controls how the contacting list will be rendered
include_once "read_template.php";
 
// layout_footer.php holds our javascript and closing html tags
include_once "footer.php";
?>