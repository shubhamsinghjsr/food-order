<?php include('partials-front/menu.php');?>



<?php

if(isset($_GET['food_id']))
{
    $food_id = $_GET['food_id'];
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($res);
    if($count==1)
    {
        // we have data
        $row = mysqli_fetch_assoc($res);
        $title =$row['title'];
        $price = $row['price'];
        $image_name = $row['image_name'];


    }
    else
    {
        // food nhai hai
        header('location:'.SITEURL);
    }

}
else
{
    header('location:'.SITEURL);
}


?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">

        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST"class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-image">
                    <?php 
                         if($image_name=="")
                         {
                            echo "<div class='error'>img nahi hai</div>";
                         }
                         else
                         {
                                ?>

                    <image src="<?php echo SITEURL; ?>image/food/<?php  echo $image_name; ?>" alt="Chicke Hawain Pizza"
                        class="image-responsive image-curve">

                        <?php
                         }
                        
                        ?>

                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value="<?php echo $title; ?>">

                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hidden" name="price" value="<?php echo $price; ?>">>

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>

                </div>

            </fieldset>

            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. yash singh" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. hi@vijaythapa.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive"
                    required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>


        <?php
// Make sure you have a database connection established before this point
// You should also sanitize user inputs to prevent SQL injection

if(isset($_POST['submit']))
{
    $food = $_POST['food'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];

    $total = $price * $qty;

    // $order_date = date("Y-m-d h:i:sa");
    // $order_date = date("Y-m-d H:i:s");


    $status = "ordered";

    $customer_name = $_POST['full-name'];
    $customer_contact = $_POST['contact'];
    $customer_email = $_POST['email'];
    $customer_address = $_POST['address'];

    // Your SQL query to insert data into the database
    $sql2 = "INSERT INTO tbl_order (food, price, qty, total, order_date, status, customer_name, customer_contact, customer_email, customer_address) 
            VALUES ('$food', '$price', '$qty', '$total', '$order_date', '$status', '$customer_name', '$customer_contact', '$customer_email', '$customer_address')";

    // Perform the SQL query
   $res2 = mysqli_query($conn, $sql2);
    
    // echo $sql2; die();

    if($res2 == true)
    {
        // Assuming you have started a session earlier
        $_SESSION['order'] = "<div class='success text-center'>Food ordered successfully</div>";
        header('location: '.SITEURL);
    }
    else
    {
        $_SESSION['order'] = "<div class='error text-center'>Food order failed</div>";
        header('location: '.SITEURL);
    }
}
?>


    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php include('partials-front/footer.php');?>