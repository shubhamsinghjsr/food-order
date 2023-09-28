<?php
include('partials-front/menu.php');

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $sql = "SELECT title FROM tbl_category WHERE id = $category_id";
    $res = mysqli_query($conn, $sql);
    
    if ($res) {
        $row = mysqli_fetch_assoc($res);
        $category_title = $row['title'];
    } else {
        header('location:' . SITEURL);
        exit; // Add an exit to stop executing further code.
    }
} else {
    header('location:' . SITEURL);
    exit; // Add an exit to stop executing further code.
}
?>

<section class="food-search text-center">
    <div class="container">
        <h2>Foods on <a href="#" class="text-white"><?php echo $category_title; ?></a></h2>
    </div>
</section>

<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        $sql2 = "SELECT id, title, price, description, image_name FROM tbl_food WHERE category_id = $category_id";
        $res2 = mysqli_query($conn, $sql2);
        $count2 = mysqli_num_rows($res2);

        if ($count2 > 0) {
            while ($row2 = mysqli_fetch_assoc($res2)) 
            {
                $id = $row2['id'];
                $title = $row2['title'];
                $price = $row2['price'];
                $description = $row2['description'];
                $image_name = $row2['image_name'];

                echo '<div class="food-menu-box">';
                echo '<div class="food-menu-image">';
                
                if (!empty($image_name)) {
                    echo '<img src="' . SITEURL . 'image/food/' . $image_name . '" alt="' . $title . '" class="image-responsive image-curve">';
                } else {
                    echo '<div class="error">Image not available</div>';
                }
                
                echo '</div>';
                echo '<div class="food-menu-desc">';
                echo '<h4>' . $title . '</h4>';
                echo '<p class="food-price">$' . $price . '</p>';
                echo '<p class="food-detail">' . $description . '</p>';
                echo '<br>';
                echo '<a href="' . SITEURL . 'order.php?food_id=' . $id . '" class="btn btn-primary">Order Now</a>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="error">No food available in this category</div>';
        }
        ?>

        <div class="clearfix"></div>
    </div>
</section>

<?php
include('partials-front/footer.php');
?>
