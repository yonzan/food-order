<?php

//Authorization-access control
//check wether the user is logged in or not
if(!isset($_SESSION['user']))//if user session is not set
{
    //user is not logged in
    //Redirect to login page with message
    $_SESSION['no-login-message'] = "<div class='error text-center'>Please Login to access to the Admin Pannel.</div>";
    //Redirect to login page
    header('location:'.SITEURL.'admin/login.php');
}



?>