<?php

include('partials/manu.php');

?>

<div class="main content">
<div class="wrapper">
    <h1>add category</h1>


    <br><br>

    <?php

if(isset($_SESSION['add']))
{
    echo $_SESSION['add'];
    unset($_SESSION['add']);
}
if(isset($_SESSION['upload']))
{
    echo $_SESSION['upload'];
    unset($_SESSION['upload']);
}
if(isset($_SESSION['failed-remove']))
{
    echo $_SESSION['failed-remove'];
    unset($_SESSION['failed-remove']);
}

    ?>
<br><br>

    <!-- add category start -->

<form action="" method="POST" enctype="multipart/form-data">

<table class="tbl-30">
    <tr>
        <td>title</td>
        <td>
            <input type="text" name="title" placeholder="categort title">
        </td>
    </tr>

    <tr>
        <td>select image</td>
        <td>
            <input type="file" name="image">
        </td>
    </tr>
    
    <tr>
        <td>featured</td>
        <td>
            <input type="radio" name="featured" value="yes"> yes
            <input type="radio" name="featured" value="no"> no
        </td>
    </tr>

    <tr>
        <td>active</td>
        <td>
            <input type="radio" name="active" value="yes"> yes
            <input type="radio" name="active" value="no"> no
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <input type="submit" name="submit" value="add-category" class="btn-secondary">
        </td>
    </tr>
    
</table>

</form>
    <!-- add category ent -->

    <?php
if(isset($_POST['submit']))
{
    // echo "click";

    $title = $_POST['title'];

    if(isset($_POST['featured']))
    {
        $featured = $_POST['featured'];

    }
    else
    {
            $featured = "no";
    }
    if(isset($_POST['active']))
    {
        $active = $_POST['active'];
    }
    else
    {
        $active = "no";
    }

    // check the image is selected or not

// print_r($_FILES['image']);

// die();

if(isset($_FILES['image']['name']))
{

    // upload image
    $image_name= $_FILES['image']['name'];

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

        header('location'.SITEURL.'admin/add-category.php');

        die ();
    }
}
else
{
    // dont upload image 
    $image_namne="";
}
    $sql = "INSERT INTO `tbl_category` SET 
    title = '$title',
     image_name ='$image_name', 
     featured = '$featured',
      active= '$active' 
      ";

    $res = mysqli_query($conn, $sql);

    if($res==TRUE)
    {
            $_SESSION['add'] = "<div class='success'>category added successfully</div>";
            header('location:'.SITEURL.'admin/manage-category.php');
    }
    else
    {
        $_SESSION['add'] = "<div class='error'>category added failed</div>";
        header('location:'.SITEURL.'admin/add-category.php');
    }
}

?>
</div>

</div>

<?php

include('partials/footer.php');

?>