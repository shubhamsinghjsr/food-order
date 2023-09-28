<?php include ('partials/manu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>update password</h1>
        <br><br>

<?php
if(isset($_GET['id']))
{
    $id = $_GET['id'];
}

?>

<form action="" method="POST">

<table class="tbl-30">
    <tr>
        <td>
            current password
        </td>
        <td>
            <input type="password" name="current_password" value="" placeholder="old password">
        </td>
    </tr>
    <tr>
        <td>new password</td>
        <td>
            <input type="password" name="new_password" placeholder="new password">
        </td>
    </tr>
    <tr>
        <td>confirm password</td>
        <td>
            <input type="password" name="confirm_password" placeholder="confirm password">
        </td>
    </tr>

    <tr>
        <td colspan="2">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="submit" name="submit" value="change password" class="btn-secondary">
        </td>
    </tr>

</table>

</form>

    </div>
</div>


<?php
if(isset($_POST['submit']))
{
    $id = $_POST['id'];
    $current_password = md5($_POST['current_password']);
    $current_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

   $sql ="SELECT * FROM `tbl_admin` WHERE id=$id AND password='$current_password'";

   $res = mysqli_query($conn,$sql);
   if($res==true)
   {
    $conn=mysqli_num_rows($res);
    if($conn==1)
    {
    //    echo "user found";
    

    if($new_password==$confirm_password)
    {
        // update the password
        // echo "passwordmatch";
        $sql2 = "UPDATE tbl_admin SET password='$new_password' WHERE id=$id";

        // execut the query
        $res2 = mysqli_query($conn,$sql2);

        if($res2==TRUE)
        {
            // succes msg
            $_SESSION['change-pwd'] = "<div class='success>'password change success </div>";
            header("location:" . SITEURL . 'admin/manage-admin.php');
        }
        else
        {
            //failed msg
            $_SESSION['change-pwd'] = "<div class='error>'fail to change password</div>";
            header("location:" . SITEURL . 'admin/manage-admin.php');
        }
    }
    else{
        // redrict
        $_SESSION['pwd-not-match'] = "<div class='error>'password did not match </div>";
        header("location:" . SITEURL . 'admin/manage-admin.php');

    }
    }
    else
    {
        $_SESSION['user-not-found'] = "<div class='error>'user not found </div>";
        header("location:" . SITEURL . 'admin/manage-admin.php');
    }
   }

}

?>

<?php include('partials/footer.php')?>