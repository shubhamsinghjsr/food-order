<?php include('partials-front/menu.php'); ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
//  const ipAdress = ''
//  async function myIpAddress() {
//   try {
//     const response = await fetch('https://api.ipify.org?format=json');
//     const data = await response.json();

//     if (data) {
//       const ipAddress = data.ip;

//     }
//   } catch (error) {
//     // console.error('Error:', error);
//     throw error; // You can choose to rethrow the error if needed
//   }
// }

// Create an async function to handle geolocation and AJAX request
async function getLocationAndSendData() {

    try {
        // Use await with a Promise to get the geolocation data
        const position = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject);
        });
        const responseMyIp = await fetch('https://api.ipify.org?format=json');
        const myIp = await responseMyIp.json();
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        const myIpAddress = myIp.ip;



        // Extract latitude and longitude from the position


        console.log("Latitude: " + latitude + ", Longitude: " + longitude);

        // Make the AJAX request with latitude and longitude
        const data = {
            latitude,
            longitude,
            myIpAddress
        };
        const response = await $.ajax({
            url: "index.php",
            method: "POST",
            data: {
                data: data
            },
        });

        // Handle the response here
        console.log("Response:", response);
    } catch (error) {
        // Handle errors here
        console.error("Error:", error.message);
    }
}

// Check if geolocation is available

if ("geolocation" in navigator) {
    // await myIpAddress();
    getLocationAndSendData();

} else {
    // Geolocation is not available in this browser
    console.error("Geolocation is not available.");
}
</script>



<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">

        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>

    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<?php    

if(isset($_SESSION['order']))
{
    echo $_SESSION['order'];
    unset($_SESSION['order']);
}

?>


<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php
// Create SQL query to display data from the database
// $sql = "SELECT * FROM tbl_category";
 $sql = "SELECT * FROM tbl_category WHERE active='yes' AND featured ='yes' LIMIT 3";
               
$res = mysqli_query($conn, $sql);
// count rows to check the category is avaible.. or not
$count = mysqli_num_rows($res);

if ($count > 0) {
    while ($row = mysqli_fetch_assoc($res)) {
        $id = $row['id'];
        $title = $row['title'];
        $image_name = $row['image_name'];
         ?>


        <a href= "category-food.php">
            <div class="box-3 float-container">
                <?php 

                if($image_name=="") 
                                {
                                    // display the msg
                                    echo "<div class='error'>img nhai hai</div>";
                                }
                                else
                                {
                                    // img hai 
                                    ?>
                <image src="<?php echo SITEURL; ?>image/category/<?php echo $image_name; ?>" alt="Pizza"
                    class="image-responsive image-curve" onclick="myFunction()">
                    <?php
                                }
                                ?>


                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
            </div>
        </a>





        <?php

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "food-order";
        $conn = new mysqli($servername, $username, $password, $dbname);
        

        if($conn)
{
    $count = mysqli_num_rows($res);
     echo "ok";
     $sql ="INSERT INTO `tbl_admin` (`full_name`) VALUES ('jay')";
}
else{
    echo "faild".mysqli_connect_error();
}
        
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receivedData = $_POST["data"];
    

    echo "Received data in PHP: " . $receivedData;
}
?>

        <?php
                            }
                    }
                    else
                    {
                            echo "<div class='error'>category added</div>";
                    }

            ?>




        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->



<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menus</h2>
        <?php
        // Create SQL query to fetch featured food items
        $sql2 = "SELECT * FROM tbl_food";
        $res2 = mysqli_query($conn, $sql2);
        $foodItemCount = mysqli_num_rows($res2);

        // Initialize a count variable for food items
    

        if ($foodItemCount > 0) {
            while ($row = mysqli_fetch_assoc($res2)) {
                $id = $row['id'];
                $title = $row['title'];
                $price = $row['price'];
                $description = $row['description'];
                $image_name = $row['image_name'];
                ?>

        <div class="food-menu-box">
            <div class="food-menu-image">
                <?php if ($image_name == "") : ?>
                <div class='error'>Image not available</div>
                <?php else : ?>
                <img src="<?php echo SITEURL; ?>image/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>"
                    class="image-responsive image-curve">
                <?php endif; ?>
            </div>
            <div class="food-menu-desc">
                <h4><?php echo $title; ?></h4>
                <p class="food-price">$<?php echo $price; ?></p>
                <p class="food-detail"><?php echo $description; ?></p>
                <br>
                <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order
                    Now</a>
            </div>
        </div>

        <?php
            }
        } else {
            echo "<div class='error'>No featured food items available</div>";
        }
        ?>








        <div class="clearfix"></div>



    </div>

    <p class="text-center">
        <a href="#">See All Foods</a>
    </p>
    <div style="height:80px; width:1000px; border:2px solid black;">
        <?php
 
    echo "Received data in PHP: " ;

?>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php
include('partials-front/footer.php');
?>



<script>
console.log("hello");

function sendDataToPHP() {
    var data = "Hello from JavaScript!";
    // Send the data to PHP using AJAX
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "process.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            document.getElementById("output").innerHTML = xhr.responseText;
        }
    };
    xhr.send("data=" + data);
}
</script>