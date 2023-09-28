<?php include('partials/manu.php'); ?>



<div class="main-content">
    <div class="wrapper">
        <h1>add admin</h1>

        <br><br>

        <?php
if(isset($_SESSION['add']))
{
    echo $_SESSION['add'];//displaying the session message if set
    unset($_SESSION['add']);//removing session message
}

?>

        <form action="#" method="POST">

<table class="tbl-30">
    <tr>
        <td>full name: </td>
        <td>
            <input type="text" name="full_name" placeholder="enter your name">
        </td>
    </tr>

    <tr>
        <td>user name</td>
<td>
    <input type="text" name="username" placeholder="your user name">
</td>
    </tr>
    <tr>
        <td>password:</td>
        <td>
            <input type="password" name="password" placeholder="your password">
        </td>
    </tr>

    <tr>
        <td colspan="2">
<input type="submit" name="submit" value="add admin" class="btn-secondary">
        </td>
    </tr>


</table>

        </form>
    </div>
</div>

<?php
include('partials/footer.php');
?>


<?php
// process the value form form and save it in db

// check wheter the submit button is clicked or not

if(isset($_POST['submit']))
{
    // button click
    // echo "button clicked";

    // get the data from form

     $full_name = $_POST['full_name'];
     $username = $_POST['username'];
     $password =md5($_POST['password']);   //password encryption with md5

    //  sql querry to save the data into db
    $sql = "INSERT INTO tbl_admin SET full_name='$full_name', username = '$username', password ='$password'";


    // eecuting query and saving data into db
 $res = mysqli_query($conn, $sql) or die(mysqli_error());

// check whether the (query is executed) daTA is INSERT OR NOT display mes
if($res==TRUE)
{
    // data inserted 
    // echo "data insertde";
    // creat a session variable to displY mes
    $_SESSION['add']="admin added successfully";
    // redirect page
    // header("location:".SITEURL.'admin/manage-admin.php');

}
 else
 {
    // field to insert data
    // echo "failed insert data";
       // creat a session variable to displY mes
       $_SESSION['add']="failed to madd admin";
       // redirect page
    //    header("location:".SITEURL.'admin/add-admin.php');
 }

}


?>