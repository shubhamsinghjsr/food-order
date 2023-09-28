<?php

include('../config/constants.php');

//1. get the id of admin to be delete 

 $id=$_GET['id'];
//creat sql query to delete admin 

$sql = "DELETE  FROM `tbl_admin` WHERE id=$id";

$res = mysqli_query($conn, $sql);

if($res==true)
{
// echo "admin delete ho gaya ";
$_SESSION['delete'] = "<div class='success'>admin delete</div>";
header("location:".SITEURL.'admin/manage-admin.php');
}
else
{
// echo "nhai huaa ";
$_SESSION['delete'] ="<div class='error'>admin not delete</div>";
header("location:".SITEURL.'admin/manage-admin.php');
}

// redirect to manage admin page with message (susess and fail)

?>