<?php   

// check the user is loggid in or not
if(!isset($_SESSION['user']))
{
    $_SESSION['no-login-message'] = "<div class='error text-center'> please login to access admin pnal.</div>";
    header('location:'.SITEURL.'admin/login.php');
}

?>