<?php

session_start();
error_reporting(0);
include("includes/config.php");
$amount=$_GET['amount'];
$studentID=$_GET['studentID'];
$coursepin=$_GET['coursepin'];
$payment_id=$_GET['payment_id'];




$sql=mysqli_query($con,"select * from course where coursePin='".$coursepin."'");
while($row=mysqli_fetch_array($sql))
{
    $nbre=$row['courseUnit'];
}
$nbre=$nbre+1;
$user=$_SESSION['login'];
//updating the number of units for this course in database
$up=mysqli_query($con,"update course set courseUnit='".$nbre."' where coursePin='".$coursepin."'");


$ret=mysqli_query($con,"insert into enrolledCourses(studentID,paiementID,price,courseID,author) values('$user','$payment_id','$amount','$coursepin','$studentID')");



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" />
</head>
<style>
._failed {
    border-bottom: solid 4px red !important;
}

._failed i {
    color: red !important;
}

._success {
    box-shadow: 0 15px 25px #00000019;
    padding: 45px;
    width: 100%;
    text-align: center;
    margin: 40px auto;
    border-bottom: solid 4px #28a745;
}

._success i {
    font-size: 55px;
    color: #28a745;
}

._success h2 {
    margin-bottom: 12px;
    font-size: 40px;
    font-weight: 500;
    line-height: 1.2;
    margin-top: 10px;
}

._success p {
    margin-bottom: 0px;
    font-size: 18px;
    color: #495057;
    font-weight: 500;
}
</style>

<body>
    <div class="container">
        <?php if($ret){ ?>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success">
                    <i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2> Your payment was successful </h2>
                    <p> Thank you for your payment. we will <br>
                        be in contact with more details shortly </p>
                </div>
            </div>
        </div>
        <?php }else{ ?>



        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="message-box _success _failed">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                    <h2> Your payment failed </h2>
                    <p> Try again later </p>

                </div>
            </div>
        </div>
        <?php }?>

    </div>
    <script>
    setTimeout(function() {
        window.location = "https://assylchouikh.rf.gd/index.php";
    }, 5000);
    </script>
</body>
</html>