<?php
include('partials/manu.php');

?>
<div class="main-content">
    <div class="wrapper">

        <h1>manage food</h1>



        <br><br><br>

        <!-- button to add  admin -->

        <a href="<?php echo SITEURL;?>admin/add-food.php" class="btn-primary">add food</a>

        <br /><br /><br />

        <?php
if(isset($_SESSION['add']))
{
    echo $_SESSION['add'];
    unset ($_SESSION['add']);
}

if(isset($_SESSION['delete']))
{
    echo $_SESSION['delete'];
    unset ($_SESSION['delete']);
}


if(isset($_SESSION['upload']))
{
    echo $_SESSION['upload'];
    unset ($_SESSION['upload']);
}

if(isset($_SESSION['unauthorize']))
{
    echo $_SESSION['unauthorize'];
    unset ($_SESSION['unauthorize']);
}

if(isset($_SESSION['upload']))
{
    echo $_SESSION['upload'];
    unset ($_SESSION['upload']);
}


?>

        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>title</th>
                <th>price</th>
                <th>image</th>
                <th>featured</th>
                <th>active</th>
                <th>action</th>
            </tr>

            <?php

                // asqli query to get all the food 
                $sql = "SELECT * FROM `tbl_food`"; // Add a semicolon at the end of this line


                $res = mysqli_query($conn, $sql);

                // count rows to cjecked we have foods or not

                $count = mysqli_num_rows($res);

                // creat serial number var and set difult value
                $sn=1;

                if($count>0)
                {
                    // we have food in db
                    // geet the food form the db and display
                    while ($row = mysqli_fetch_assoc($res))
                    {
                        // get the value from indivisual colm
                        $id = $row['id'];
                        $title = $row['title'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];
                        $featured = $row['featured'];
                        $active = $row['active'];
                        ?>

            <tr>
                <td><?php echo $sn++; ?></td>
                <td><?php echo $title; ?></td>
                <td>$<?php echo $price; ?></td>
                <td>

                    <?php 
                    
                    // checked we have img or not 
                    if($image_name=="")
                    {
                        // we do not have img display error msg 
                        echo "<div class='error'>image not added </div>";

                    }
                    else
                    {
                        ?>

                            <img src="<?php echo SITEURL;?>image/food/<?php echo $image_name ?>" width="100px">

                        <?php

                    }
                    
                    ?>

                </td>
                <td><?php echo $featured; ?></td>
                <td><?php echo $active; ?></td>
                <td>
                    <a href="<?php echo SITEURL;?>admin/update-food.php?id=<?php echo $id; ?>" class="btn-secondary">update food</a>
                    <a href="<?php echo SITEURL;?>admin/delete-food.php?id=<?php echo $id; ?>&image_name=<?php echo $image_name; ?>" class="btn-denger">delete admin</a>/
                    
                </td>
            </tr>

            <?php
                    }
                }
                else
                {
                    // food not in db
                    echo "<tr> <td colspan='7' class='error'> food not added yet. </td> </tr>";

                }
                ?>


        </table>
    </div>
</div>
<?php
include('partials/footer.php')
?>