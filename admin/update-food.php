<?php
include('partials/manu.php');

?>

<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM tbl_food WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $res2 = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($res2)) {
        $title = $row['title'];
        $description = $row['description'];
        $price = $row['price'];
        $current_image = $row['image_name'];
        $current_category = $row['category_id'];
        $featured = $row['featured'];
        $active = $row['active'];
    } else {
        header('location: ' . SITEURL . 'admin/manage-food.php');
        exit();
    }
} else {
    header('location: ' . SITEURL . 'admin/manage-food.php');
    exit();
}
?>


<div class="main-content">
    <div class="wrapper">
        <h1>update food</h1>
        <br>

        <form action="update-food.php" method="POST" enctype="multipart/form-data">
            <!-- form fields go here -->



            <table class="tbl-30">
                <tr>
                    <td>title</td>
                    <td>
                        <input type="text" name="title" placeholder="tittle the food" value="<?php echo $title; ?>">
                    </td>
                </tr>


                <tr>
                    <td>description</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"><?php echo $description; ?></textarea>
                    </td>
                </tr>

                <tr>
                    <td>price</td>
                    <td>
                        <input type="number" name="price" value=<?php echo $current_image; ?>>
                    </td>
                </tr>


                <tr>
                    <td>current image</td>
                    <td>
                        <?php
                    if($current_image == "")
                    {
                        echo "<div class='error'>image nahi hai</div>";
                    }
                    else
                    {
                        ?>

                        <img src="<?php echo SITEURL;?>image/food<?php echo $current_imagev; ?>">
                        <?php

                    }
                    ?>
                    </td>
                </tr>

                <tr>
                    <td>select new img</td>
                    <td>
                        <input type="file" name="image" value=<?php echo $price; ?>>
                    </td>
                </tr>


                <tr>
                    <td>category</td>
                    <td>
                        <select name="category">

                            <?php
                            // Fetch and display categories
                            $sql = "SELECT * FROM tbl_category WHERE active='yes'";
                            $res = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($res) > 0) {
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_title = $row['title'];
                                    $category_id = $row['id'];
                                    // echo "<option value='$category_id'>$category_title</option>";
                                    ?>
                            <option <?php if($current_category==$category_id){echo "selected";} ?>
                                value="<?php echo $category_id; ?>"><?php echo $category_title; ?></option>
                            <?php
                                }
                            } else {
                                echo "<option value='0'>No categories available</option>";
                            }
                            ?>

                        </select>
                    </td>
                </tr>

                <tr>

                    <td>fatured</td>
                    <td>
                        <input <?php if($featured=="yes") {echo "checked";} ?> type="radio" name="fatured" value="yes">
                        yes
                        <input <?php if($featured=="yes") {echo "checked";} ?> type="radio" name="fatured" value="no"> no

                    </td>
                </tr>

                <tr>
                    <td>active</td>
                    <td>
                        <input <?php if($active=="yes") {echo "checked";} ?> type="radio" name="active" value="yes"> yes
                        <input <?php if($active=="no") {echo "checked";} ?> type="radio" name="active" value="no"> no
                    </td>
                </tr>

                <tr>
                    <td>
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">

                        <input type="submit" name="submit" value="update food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php
// session_start(); // Start the session if not already started

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price']; // Fixed variable name
    $current_image = $_POST['current_image']; // Fixed variable name
    $category = $_POST['category']; // Make sure to initialize this

    // You should validate and sanitize user input here

    // Check if a new image was uploaded
    if (isset($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        if ($image_name != "") {
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_name = "food-name" . rand(0000, 9999) . "." . $ext;
            $src_path = $_FILES['image']['tmp_name'];
            $dest_path = "../image/food/" . $image_name;

            // Perform the file upload
            if (move_uploaded_file($src_path, $dest_path)) {
                // Delete the old image if it exists
                if (!empty($current_image)) {
                    $remove_path = "../image/food/" . $current_image;
                    if (file_exists($remove_path)) {
                        unlink($remove_path);
                    }
                }
            } else {
                $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                header('location: ' . SITEURL . 'admin/add-food.php');
                die();
            }
        }
    } 
    else 
    {
        // No new image uploaded, use the current image
        $image_name = $current_image;
    }

    

    // Update the food in the database using a prepared statement to prevent SQL injection
    $sql3 = "UPDATE tbl_food SET
        title = ?,
        description = ?,
        image_name = ?,
        category_id = ?,
        featured = ?,
        active = ?
        WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql3);
    mysqli_stmt_bind_param($stmt, "ssssiii", $title, $description, $image_name, $category, $featured, $active, $id);
    $res3 = mysqli_stmt_execute($stmt);

    if ($res3) {
        $_SESSION['upload'] = "<div class='success'>Food uploaded successfully.</div>";
        header('location: ' . SITEURL . 'admin/manage-food.php');
    } else {
        $_SESSION['upload'] = "<div class='error'>Failed to update food.</div>";
        header('location: ' . SITEURL . 'admin/manage-food.php');
    }
}
?>



    </div>
</div>








<?php
include('partials/footer.php')
?>