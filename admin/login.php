<?php include('../config/constants.php')?>

<html>
    <head>
<title>login - food order system</title>
<link rel="stylesheet" href="../css/admin.css">

</head>
<body>
    <div class="login">
        <h1 class="text-center">login</h1><br><br>

        <?php

            if(isset($_SESSION['login']))
            {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-message']))
            {
                echo $_SESSION['no-login-message'];
                unset ($_SESSION['no-login-message']);
            }

        ?>

        <br>

        <!-- form start here -->

<form action="" method="POST" class="text-center">
    username: <br>
    <input type="text" name="username" placeholder="enter username"><br><br>
    password:<br>
    <input type="password" name="password" placeholder="enter your password"><br><br>
    <input type="submit" name="submit" value="login" class="btn-primary"> <br><br>
</form>

        <!-- form end here -->

        
        <p class="text-center">created by - <a href="www.yashsingh.com">yash singh</a></p>
    </div>
</body>
</html>


<?php

if(isset($_POST['submit']))
{
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    // $sql = "SELECT * FROM `tbl_admin` WHERE username='$username' AND password='$password'";
    $sql = "SELECT * FROM `tbl_admin` WHERE username='$username' AND password='$password'";

    $res = mysqli_query($conn,$sql);

    $count = mysqli_num_rows($res);

    if($count==1)
    {
        $_SESSION['login'] = "<div class='success'>login successful</div>";
        $_SESSION['user'] = $username; //to check the user is login or notand logout will unset it

        header('location:'.SITEURL.'admin/');
    }
    else
    {
        $_SESSION['login'] = "<div class='error text-center'>username and password do not match</div>";
        // header('location:'.SITEURL.'admin/login.php');
    }



}

?>