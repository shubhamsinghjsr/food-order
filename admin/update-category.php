<?php
include ('partials/manu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>update category</h1>


        <br><br>

        <?php

// check the id is set or not
if(isset($_GET['id']))
{
//    echo "geating the data";
$id = $_GET['id'];
$sql = "SELECT * FROM `tbl_category` WHERE id=$id ";

$res = mysqli_query($conn, $sql);

$count = mysqli_num_rows($res);


if($count==1)
{
        $row = mysqli_fetch_assoc($res);
        $title = $row['title'];
        $current_image = $row['image_name'];
        $featured = $row['featured'];
        $active = $row['active'];

}
else
{
    $_SESSION['no-category'] = "<div class = 'error'>category not found.</div>";
    header('location'.SITEURL.'admin/manage-category.php');
}
}
else
{
    // redirech to manage category
    header('location:'.SITEURL.'admin/manage-category.php');
}

?>


        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>title:</td>
                    <td>
                        <input type="text" name="title" value="<?php echo $title; ?>">
                    </td>
                </tr>

                <tr>
                    <td>current image</td>
                    <td>
                        <?php
                       if($current_image != "")
                       {
                        // display the image
                        ?>

                        <image src="<?php  echo SITEURL; ?>image/category/<?php  echo $current_image ?>">

                        <?php
                       }
                       else
                       {
                        // display msg
                        echo "<div class='error'>image not add</div>";
                       }
                       ?>
                    </td>
                </tr>

                <tr>
                    <td>new image:</td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>

                <td>featured: </td>
                <td>
                    <input <?php if($featured=="yes"){echo "checked";} ?> type="radio" name="featured" value="yes"> yes

                    <input <?php if($featured=="no"){echo "checked";} ?> type="radio" name="featured" value="no"> no
                </td>
                <tr>
                </tr>

                <tr>
                    <td>active:</td>
                    <td>
                        <input <?php if($active=="yes"){echo "checked";} ?> type="radio" name="active" value="yes"> yes

                        <input <?php if($active=="no"){echo "checked";} ?> type="radio" name="active" value="no"> no
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="current_image" value="<?php echo $current_image ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="update category" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>

        <?php

if(isset($_POST['submit']))
{

// uploding new image 

if(isset($_FILES['image']['name']))
{
    $image_name = $_FILES['image']['name'];


   if($image_name !="")
   {
    // image hai
    //a upload new image



    // auto rename image
    // $ext = end(explode('.', $image_name));
    $image_name_parts = explode('.', $image_name);
    $ext = end($image_name_parts);



    // rename image

    $image_name= "food_category_".rand(000, 999).'.'.$ext;

    

    $source_path = $_FILES['image']['tmp_name'];

    $destination_path = "../image/category/".$image_name;

    $upload = move_uploaded_file($source_path,$destination_path);

    if($upload==false)
    {
        $_SESSION['upload'] = "<div class='error'>failed to upoad image. </div>";

        header('location:'.SITEURL.'admin/manage-category.php');


        die ();
    }

    

    //2 remove the cruunt image if available
    if($current_image!="")
    {
        $remove_path = "../image/category/".$current_image;

        $remove = unlink($remove_path);
        
        
        if($remove==false)
        {
            $_SESSION['failed-remove'] = "<div class= 'error'>failed to remove curunt image</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
            die();
        }
    }



   }
   else
   {
    $image_name = $current_image;
   }
}
else
{
    $image_name = $current_image;
}

    // echo "kar gaya";

    $id = $_POST['id'];
    $title = $_POST['title'];
    $current_image = $_POST['current_image'];
    $featured = $_POST['featured'];
    $active = $_POST['active'];

    // 3 update the db

$sql2= "UPDATE `tbl_category` SET
         title = '$title',
         image_name = '$image_name',
         featured = '$featured',
         active = '$active'
         WHERE id=$id
     ";

    // execut the qurry 
    $res2 = mysqli_query($conn, $sql2);


    // checked executed or not
    if($res2==true)
    {
        $_SESSION['update'] = "<div class='success'>category update</div>";
        header('location'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        $_SESSION['update'] = "<div class='error'>failed to update</div>";
        header('location'.SITEURL.'admin/manage-category.php');
    }
    
}

?>


    </div>
</div>



<?php
include ('partials/footer.php');
?>