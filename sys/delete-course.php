<?php 

session_start();
include('../includes/config.php');
$a = $_GET['id'];
$sql=mysqli_query($con,"DELETE FROM course where coursePin='$a'");
if($sql){
    $_SESSION['del']="Course Deleted!";
}else{
    $_SESSION['del']="Something went Wrong !";
}
header('location:../profile.php');
exit();



?>