<?php
session_start();
error_reporting(0);
include("includes/config.php");
if(strlen($_SESSION['alogin'])!=0)
    {   
header('location:profile.php');
}else{
if(isset($_POST['submit']))
{
    $username=$_POST['username'];
    $password=md5($_POST['password']);
$query=mysqli_query($con,"SELECT * FROM admin WHERE username='$username' and password='$password'");
$num=mysqli_fetch_array($query);
if($num>0)
{
$_SESSION['alogin']=$_POST['username'];
$_SESSION['id']=$num['id'];
header("location:profile.php");
exit();
}
else
{
$_SESSION['errmsg']="Invalid username or password";
header("location:index.php");
exit();
}
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="styles.css" />
    <title>Log In</title>
</head>
<body>
    <div class="login-box">
        <h2>Login</h2>
        <span
            style="color:red;"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>

        <form name="admin" method="post">
            <div class="user-box">
                <input type="text" name="username" required="" />
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" required />
                <label>Password</label>
            </div>
            <a href="#">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <input type="submit" name="submit" value="Submit" id="">
            </a>
        </form>
    </div>
</body>
</html>
<?php }?>