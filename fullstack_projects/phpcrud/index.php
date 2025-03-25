<?php
include 'functions.php';

// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Home Page template below.
?>

<?=template_header('Home')?>

<div class="content">
  <h2>Home</h2>
  <p>Contacts Home Page.  Feel free to view your contacts.</p>
</div>

<?=template_footer()?>