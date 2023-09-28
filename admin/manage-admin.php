<?php
include('partials/manu.php');
?>



<!-- main content section start -->

<div class="main-content">
    <div class="wrapper">
        <h1>manage admin</h1>

        <br><br><br>

        <?php
    if(isset($_SESSION['add']))
    {
        echo $_SESSION['add']; //displaying session message
        unset($_SESSION['add']); //removing session message
    }
    if(isset($_SESSION['delete']))
    {
        echo $_SESSION['delete'];
        unset($_SESSION['delete']);
    }

    if(isset($_SESSION['user-not-found']))
    {
        echo $_SESSION['user-not-found'];
        unset ($_SESSION['user-not-found']);
    }
    if(isset($_SESSION['pwd-not-match']))
    {
        echo $_SESSION['pwd-not-match'];
        unset ($_SESSION['pwd-not-match']);
    }
    
    if(isset($_SESSION['change-pwd']))
    {
        echo $_SESSION['change-pwd'];
        unset($_SESSION['change-pwd']);
    }

?>
        <br><br><br>


        <!-- button to add  admin -->

        <a href="add-admin.php" class="btn-primary">add admin</a>

        <br /><br /><br />
        <table class="tbl-full">
            <tr>
                <th>S.N</th>
                <th>Full Name</th>
                <th>username</th>
                <th>action</th>
            </tr>


            <?php
        // query to get all admin 
$sql = "SELECT * FROM `tbl_admin`";
// execut the query 
$res = mysqli_query($conn , $sql);

// check whether the query executed of not 
if($res==TRUE)
{
    // count rows we have data in db or not
    $count = mysqli_num_rows($res);  //function to get all the rows in db 

    $sn=1; //creat a variable and assign the value
    //check the number of rows 
    if($count>0)
    {
            while($rows=mysqli_fetch_assoc($res))
            {
                // useing while loop to get all the data form db
                // and while loop will run as long as we have data in db 


                // get individual data
                $id=$rows['id'];
                $full_name=$rows['full_name'];
                $username =$rows['username'];

                // diplay the value in our table
                ?>

            <tr>
                <td><?php echo $sn++;?></td>
                <td><?php echo $full_name; ?></td>
                <td><?php echo $username; ?></td>
                <td>
                    <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>"
                        class="btn-primary">change password</a>
                    <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>"
                        class="btn-secondary">update admin</a>
                    <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>"
                        class="btn-denger">delete admin</a>
                </td>
            </tr>
            <?php
            }
    }
    else
    {

    }
}

?>
        </table>
    </div>
</div>

<!-- main content section end -->
<?php
include('partials/footer.php');
  ?>