<?php

// include constance page
include('../config/constants.php');

if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    // Process to delete
    // echo "Process to delete";

    // get id and img name

    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // remove the img if available 
    if($image_name != "")
    {
        $path = "../image/food/".$image_name;
        $remove = unlink($path);
        
        if($remove==false)
        {
            $_SESSION['upload'] = "<div class = 'error'>failed to remove img file.</div>";
          header('location'.SITEURL.'admin/manage-food.php');
          die();
        }
    }
    // dekete food form db

    $sql = "DELETE FROM tbl_food WHERE id=$id";
    $res = mysqli_query($conn, $sql);
    
    if($res==true)
    {
        // food delete
        $_SESSION['delete'] = "<div class = 'success'>food delete.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    else
    {
        // failed to delete food 
        $_SESSION['delete'] = "<div class = 'error'>food delete failed.</div>";
        header('location:'.SITEURL.'admin/manage-food.php');
    }
    // redrict to manage food with sesion manage
}
else
{
    // Redirect to manage food page
    // echo "redirect";
    $_SESSION['unauthorize'] = "<div class='error'>unauthorized access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}
?>
