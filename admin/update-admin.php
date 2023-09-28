<?php

include('partials/manu.php');
?>


<div class="main-content">
    <div class="wrapper">
        <h1>update admin page</h1>
        <br><br>

        <?php

       $id=$_GET['id'];
       $sql ="SELECT * FROM `tbl_admin` WHERE id=$id";
       $res=mysqli_query($conn,$sql);
       if($res==TRUE)
       {
        $count=mysqli_num_rows($res);

        if($count==1)
        {
            // echo "admin hai";
            $row =mysqli_fetch_assoc($res);

            $full_name = $row['full_name'];
            $username = $row['username'];
        }
        else 
        {
            header("location:".SITEURL.'admin/manage-admin.php');
        }
       }

?>

        <form action="#" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>full name:</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name; ?>">
                    </td>
                </tr>
                <tr>
                    <td>username:</td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                    <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="update admin" class="btn-secondary">
                    </td>
                </tr>

            </table>
        </form>
    </div>
</div>


<?php

if (isset($_POST['submit']))
{
    // echo "button click";
  $id = $_POST['id'];
$full_name = $_POST['full_name'];
$username = $_POST['username'];


// Perform the SQL update query here
$sql = "UPDATE `tbl_admin` SET full_name='$full_name', username='$username' WHERE id=$id";
$res = mysqli_query($conn, $sql);

if ($res == TRUE) {
    // Redirect to the admin management page after successful update
    header("location:" . SITEURL . 'admin/manage-admin.php');
} else {
    // Handle the error if the update query fails
    echo "Failed to update admin information. Please try again.";
}
}


?>

<?php
include('partials/footer.php');
?>