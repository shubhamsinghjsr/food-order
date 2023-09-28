<?php
include('partials/manu.php');

?>
<div class="main-content">
    <div class="wrapper">

        <h1>add food</h1>
        <br><br>
        <?php
    if(isset($_SESSION['upload']))
    {
        echo $_SESSION['upload'];
        unset($_SESSION['upload']);
    }
?>

        <form action="" method="POST" enctype="multipart/form-data">

            <br /><br />
            <table class="tbl-30">
                <tr>
                    <td>title</td>
                    <td>
                        <input type="text" name="title" placeholder="tittle the food">
                    </td>
                </tr>


                <tr>
                    <td>description</td>
                    <td>
                        <textarea name="description" cols="30" rows="5"
                            placeholder="description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>price</td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>


                <tr>
                    <td>select image</td>
                    <td>
                        <input type="file" name="file">
                    </td>
                </tr>
                <tr>
                    <td>category</td>
                    <td>
                        <select name="category">

                            <?php
                // create PHP code category in the database
                // create SQL to get active categories from the database
                $sql = "SELECT * FROM `tbl_category` WHERE active = 'yes'";
                // execute the query
                $res = mysqli_query($conn, $sql);

                // count rows to check if we have categories or not
                $count = mysqli_num_rows($res);

                // if the count is greater than zero, we have categories
                if ($count > 0) {
    // we have categories
    while ($row = mysqli_fetch_assoc($res)) { // Corrected the typo 'fatch' to 'fetch'
        // get the details of the category
        $id = $row['id'];
        $title = $row['title'];
        ?>
                            <option value="<?php echo $id; ?>"><?php echo $title; ?></option>
                            <?php
    }
} else {
    // we do not have categories
    ?>
                            <option value="0">No category found</option>
                            <?php
}
// display on drop-down
?>


                        </select>
                    </td>
                </tr>
                <tr>

                    <td>fatured</td>
                    <td>
                        <input type="radio" name="fatured" value="yes"> yes
                        <input type="radio" name="fatured" value="no"> no

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
                        <input type="submit" name="submit" value="add food" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>


        <?php
// include('partials/manu.php');
// session_start(); // Start a session if not already started

// // Include the database connection file
// include 'db_connect.php';

if (isset($_POST['submit'])) {
    // Sanitize and validate user inputs
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']); // Convert to float for safety
    $category_id = intval($_POST['category']); // Convert to int for safety

    // Check if the radio buttons for featured and active are checked
    $featured = isset($_POST['featured']) ? mysqli_real_escape_string($conn, $_POST['featured']) : "no";
    $active = isset($_POST['active']) ? mysqli_real_escape_string($conn, $_POST['active']) : "no";

    // Upload the image if selected
    if (isset($_FILES['file']['name'])) {
        $image_name = $_FILES['file']['name'];

        if ($image_name != "") {
            $ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $image_name = "food-name" . rand(0000, 9999) . "." . $ext;
            $src = $_FILES['file']['tmp_name'];
            $dst = "../image/food/" . $image_name;

            if (move_uploaded_file($src, $dst)) {
                // Image uploaded successfully
            } else {
                $_SESSION['upload'] = "<div class='error'>Failed to upload image</div>";
                header('location: ' . SITEURL . 'admin/add-food.php');
                die();
            }
        }
    } else {
        $image_name = "";
    }

    // Create a SQL query using prepared statement to save and add food
    $sql2 = "INSERT INTO `tbl_food` (title, description, price, image_name, category_id, featured, active) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql2);
    mysqli_stmt_bind_param($stmt, "ssdssss", $title, $description, $price, $image_name, $category_id, $featured, $active);
    $res2 = mysqli_stmt_execute($stmt);

    if ($res2) {
        $_SESSION['add'] = "<div class='success'>Successfully added</div>";
        header('location: ' . SITEURL . 'admin/manage-food.php');
    } else {
        $_SESSION['add'] = "<div class='error'>Failed to add</div>";
        header('location: ' . SITEURL . 'admin/manage-food.php');
    }
}
?>

<!-- The rest of your HTML code remains the same -->








    </div>
</div>




<?php
include('partials/footer.php')
?>