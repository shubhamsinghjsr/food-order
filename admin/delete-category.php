<?php
include('../config/constants.php');
// echo "delete page";
if(isset($_GET['id']) AND isset($_GET['image_name']))
{
    // get the value and delete
    // echo "get value and delete";
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    // remove the physical image file is available
        if($image_name !="")
        {
            // image is avibable so remove it
            $path = "../image/category/".$image_name;
            $remove = unlink($path);

            if($remove==false)
            {
                $_SESSION['remove'] = "<div class='error'>failed to remove category image</div>";

                header('location:'.SITEURL.'admin/manage-category.php');
                die();
            }
        }
        $sql = "DELETE FORM tbl_cotegory WHERE id=$id";

        // execute the query
        $res = mysqli_query($conn,$sql);

        if($res==true)
        {
            // set success msg and redirect 
            $_SESSION['delete'] = "<div class='success'>category delete successfully .</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
        
        else
        {
            // ste failed msg rediresc
            $_SESSION['delete'] = "<div class='error'>category delete failed.</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
        }
}
else
{
    // redirech to mange category page
    header('location:'.SITEURL.'admin/manage-category.php');
}

?>