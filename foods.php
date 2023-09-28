<?php include('partials-front/menu.php');?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php  echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->



    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>


            <?php
                 $sql = "SELECT * FROM tbl_food WHERE active='yes'";
                 $res = mysqli_query($conn, $sql);
                 
                 $foodItemCount = mysqli_num_rows($res);
                 if ($foodItemCount > 0)
                 {
                    // food hai

                    while ($row = mysqli_fetch_assoc($res))
                    {
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

<div class="food-menu-box">
                <div class="food-menu-image">

                <?php

                    if($image_name=="")
                    {
                        echo "<div class='error'>img nahi hai</div>";

                    }
                    else
                    {
                        ?>
 <image src="<?php echo SITEURL; ?>image/food/<?php  echo $image_name; ?>" alt="Chicke Hawain Pizza" class="image-responsive image-curve">
                        <?php
                    }


                  ?>
                   
                </div>

                <div class="food-menu-desc">
                    <h4><?php echo $title; ?></h4>
                    <p class="food-price">$<?php echo $price; ?></p>
                    <p class="food-detail">
                    <?php echo $description; ?>
                    </p>
                    <br>

                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                </div>
            </div>

                         <?php
                    }
                 }
                 else
                 {
                    // food nahi hai
                    echo "<div class='error'>No featured food items available</div>";
                 }


?>

         

      



          


            <div class="clearfix"></div>

            

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php');?>