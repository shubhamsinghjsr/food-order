<?php

include('partials-front/menu.php');
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
async function getLocationAndSendData(image_name) {

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
    const itemName = image_name;
    const date = new Date();
    // Extract latitude and longitude from the position


    console.log("Latitude: " + latitude + ", Longitude: " + longitude);

    // Make the AJAX request with latitude and longitude
    const data = {
        latitude,
        longitude,
        myIpAddress,
        itemName,
        date


    };
    const response = await $.ajax({
        url: "categories.php",
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





<!-- CAtegories Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Food</h2>

        <?php

$sql = "SELECT * FROM tbl_category WHERE active = 'yes'";


$res = mysqli_query($conn,$sql);

$count = mysqli_num_rows($res);

if($count>0)
{
        while($row=mysqli_fetch_assoc($res))
        {
            $id = $row['id'];
            $title = $row['title'];
            $image_name = $row['image_name'];

            ?>

       
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
                                      <image  src="<?php echo SITEURL; ?>image/category/<?php echo $image_name;?>" alt="Pizza"
                                  class="image-responsive image-curve"  onclick="getLocationAndSendData('<?php echo $title;?>')" id="abc">
                                <?php
   

   
                }
                ?>

<!-- 
                <image src="image/pizza.jpg" alt="Pizza" class="image-responsive image-curve"> -->

                    <h3 class="float-text text-white"><?php echo $title; ?></h3>
            </div>
        </a>

        <?php

        }
    }
    else
    {

    }

            ?>



        <div class="clearfix"></div>
    </div>
</section>
<!-- Categories Section Ends Here -->

<?php


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";
$conn = new mysqli($servername, $username, $password, $dbname);


if($conn)
{
echo "ok";
if(isset($_POST['data'])){
    $receivedData = $_POST['data'];
    if (isset($receivedData['latitude']) && isset($receivedData['longitude'])) {
        //  Extract latitude from the received data
        $latitude = $receivedData['latitude'];
        $longitude = $receivedData['longitude'];
         $myIpAdress = $receivedData['myIpAddress'];
         $itemName = $receivedData['itemName'];
         $date = $receivedData['date'];
  
      $receivedConstant = $_POST['data'];
     $sql ="INSERT INTO `location` (`latitude`, `longitude`, `ip_adrs`, `product_name`, `data_time`) VALUES ('$latitude', '$longitude', '$myIpAdress', '$itemName', '$date');";
     if($conn->query($sql)==TRUE){
       echo "record inserted";
   
      }
    }

   
}
else{
    echo "Constant not received in PHP.";
}


// $lat = $_POST['json'];

}
else{
echo "faild".mysqli_connect_error();
}


?>

<?php include('partials-front/footer.php'); ?>






