<?php
session_start();
include('includes/config.php');
error_reporting(0);




                     echo "<script>alert(".'$_SESSION["alogin"]'.")</script>"   ;                

// Check if a message is set in the session
if(isset($_SESSION['del'])) {
    echo '<script>alert("'.$_SESSION['del'].'")</script>';
    // Unset the session variable to clear the message
    unset($_SESSION['del']);
}



// Check if a message is set in the session
if(isset($_SESSION['message'])) {
    echo '<script>alert("'.$_SESSION['message'].'")</script>';
    // Unset the session variable to clear the message
    unset($_SESSION['message']);
}


$user=$_SESSION['alogin'];

$sql = "SELECT * from course where author='$user'";
$result = mysqli_query($con, $sql);






if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
    $totmoney=mysqli_query($con,"select sum(price) as totmoney from enrolledCourses where author='".$_SESSION['alogin']."'"); 
    while ($row = mysqli_fetch_assoc($totmoney)) {
        $totalamount = $row["totmoney"];
        
    }
    $totalamount=$totalamount/1000;
date_default_timezone_set('Asia/Kolkata');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );


if(isset($_POST['submit']))
{
$sql=mysqli_query($con,"SELECT password FROM  admin where password='".md5($_POST['cpass'])."' && username='".$_SESSION['alogin']."'");
$num=mysqli_fetch_array($sql);
if($num>0)
{
 $con=mysqli_query($con,"update admin set password='".md5($_POST['newpass'])."', updationDate='$currentTime' where username='".$_SESSION['alogin']."'");
echo '<script>alert("Password Changed Successfully !!")</script>';
echo '<script>window.location.href=change-password.php</script>';
}else {
echo '<script>alert("Old Password not match !!")</script>';
echo '<script>window.location.href=change-password.php</script>';
}
}








?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Connect Courses - Profile</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="style.css">
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>
<style>
.walletBalanceCard {
    width: fit-content;
    height: 55px;
    background-color: #2777eb;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    gap: 12px;
    padding: 0px 12px;
    font-family: Arial, Helvetica, sans-serif;
}

.svgwrapper {
    width: 28px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.svgwrapper svg {
    width: 100%;
}

.balancewrapper {
    display: flex;
    align-items: flex-start;
    justify-content: flex-start;
    flex-direction: column;
    width: 120px;
    gap: 0px;
}

.balanceHeading {
    font-size: 8px;
    color: rgb(214, 214, 214);
    font-weight: 100;
    letter-spacing: 0.6px;
}

.balance {
    font-size: 13.5px;
    color: white;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.addmoney {
    padding: 1px 15px;
    border-radius: 20px;
    background-color: #2777eb;
    color: white;
    border: none;
    font-size: 12px;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
}

.addmoney:hover {
    background-color: whitesmoke;
    color: #2777eb;
}

.plussign {
    font-size: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
<script type="text/javascript">
function valid() {
    if (document.chngpwd.cpass.value == "") {
        alert("Current Password Filed is Empty !!");
        document.chngpwd.cpass.focus();
        return false;
    } else if (document.chngpwd.newpass.value == "") {
        alert("New Password Filed is Empty !!");
        document.chngpwd.newpass.focus();
        return false;
    } else if (document.chngpwd.cnfpass.value == "") {
        alert("Confirm Password Filed is Empty !!");
        document.chngpwd.cnfpass.focus();
        return false;
    } else if (document.chngpwd.newpass.value != document.chngpwd.cnfpass.value) {
        alert("Password and Confirm Password Field do not match  !!");
        document.chngpwd.cnfpass.focus();
        return false;
    }
    return true;
}
</script>

<body>
    <!-- Topbar Start -->
    <?php include('includes/topbar.php'); ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <?php include("includes/navbar.php"); ?>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px;">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">Profile</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="index.php">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Profile</p>
            </div>

        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid w-100">
        <div class="container">
            <div class="row">
                <div class="walletBalanceCard mb-5">
                    <div class="svgwrapper">
                        <svg viewBox="0 0 24 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="0.539915" y="6.28937" width="21" height="4" rx="1.5"
                                transform="rotate(-4.77865 0.539915 6.28937)" fill="#7D6B9D" stroke="black"></rect>
                            <circle cx="11.5" cy="5.5" r="4.5" fill="#E7E037" stroke="#F9FD50" stroke-width="2">
                            </circle>
                            <path
                                d="M2.12011 6.64507C7.75028 6.98651 12.7643 6.94947 21.935 6.58499C22.789 6.55105 23.5 7.23329 23.5 8.08585V24C23.5 24.8284 22.8284 25.5 22 25.5H2C1.17157 25.5 0.5 24.8284 0.5 24V8.15475C0.5 7.2846 1.24157 6.59179 2.12011 6.64507Z"
                                fill="#BF8AEB" stroke="black"></path>
                            <path
                                d="M16 13.5H23.5V18.5H16C14.6193 18.5 13.5 17.3807 13.5 16C13.5 14.6193 14.6193 13.5 16 13.5Z"
                                fill="#BF8AEB" stroke="black"></path>
                        </svg>
                    </div>

                    <div class="balancewrapper">
                        <span class="balanceHeading">Wallet balance</span>
                        <p class="balance"><?php echo $totalamount?><span id="currency"> DT</span></p>
                    </div>

                    <button class="addmoney"><span class="plussign">+</span>Withdraw</button>
                </div>
                <span
                    style="color:red;"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>
                <div class="container p-0">
                    <h1 class="h3">Settings</h1>
                    <div class="row">
                        <div class="col-md-5 col-xl-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">Profile Settings</h5>
                                </div>
                                <div class="list-group list-group-flush" role="tablist">

                                    <a class="list-group-item list-group-item-action active" data-toggle="list"
                                        href="#password" role="tab">
                                        Password
                                    </a>
                                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#courses"
                                        role="tab">
                                        Courses
                                    </a>
                                    <a class="list-group-item list-group-item-action" data-toggle="list"
                                        href="#encourses" role="tab">
                                        Enrolled Courses
                                    </a>

                                    <a class="list-group-item list-group-item-action" data-toggle="list" href="#"
                                        role="tab">
                                        Delete account
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7 col-xl-8">
                            <div class="tab-content">

                                <div class="tab-pane fade show active" id="password" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Change Password</h5>
                                            <form name="chngpwd" method="post" class="row g-3"
                                                onSubmit="return valid();">
                                                <div class="col-md-12 mb-3">
                                                    <div class="">
                                                        <input class="form-control " name="cpass"
                                                            placeholder="Enter Current Password" id="floatingTextarea"
                                                            id="exampleInputPassword1" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-3">
                                                    <div class="">
                                                        <input class="form-control" name="newpass"
                                                            placeholder="Enter New Password" id="floatingTextarea"
                                                            id="exampleInputPassword1" required>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mb-3">
                                                    <div class="">
                                                        <input class="form-control" type="text" name="cnfpass"
                                                            placeholder="Enter Confirm Password" id="floatingTextarea"
                                                            id="exampleInputPassword1" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 mb-5">
                                                    <input type="submit" name="submit" class="btn btn-primary w-100"
                                                        value="Next">
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="courses" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Courses By You</h5>
                                            <?php 
                                    if(mysqli_num_rows($result) == 0) {
                                        // Display a paragraph if the courses table is null
                                        echo "<p>No courses available at the moment.</p>";
                                    } else {
                                        // Iterate through the results if there are rows in the table
                                    ?>
                                            <div>
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>#</td>
                                                            <td>Course Name</td>
                                                            <td>Course price</td>
                                                            <td>Update</td>
                                                            <td>Actions</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Populate the table with data from the database -->
                                                        <?php   $count=1;  while ($row = mysqli_fetch_assoc($result)) {?>

                                                        <tr>
                                                            <td><?php echo $count;?></td>
                                                            <td><?php echo  $row['courseName']; ?></td>
                                                            <td><?php echo $row['price'] ;?> DT</td>
                                                            <td><?php echo $row['updationDate'] ;?></td>
                                                            <td>
                                                                <!-- Button trigger modal -->
                                                                <a
                                                                    href="course-edit.php?id=<?php echo $row['coursePin']; ?>"><button
                                                                        class="btn btn-info btn-sm">Edit</button></a>
                                                                <a
                                                                    href="./sys/delete-course.php?id=<?php echo $row['coursePin']; ?>"><button
                                                                        class="btn btn-danger btn-sm">Delete</button></a>



                                                        </tr>
                                                        <?php 
                                                        $count++;
                                                    }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="encourses" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Enrolled Courses History</h5>
                                            <?php 
                                            $sql2=mysqli_query($con,"Select * from enrolledCourses where studentID='".$_SESSION['alogin']."'");
                                    if(mysqli_num_rows($sql2) == 0) {
                                        // Display a paragraph if the courses table is null
                                        echo "<p>No courses Enrolled at the moment.</p>";
                                    } else {
                                        // Iterate through the results if there are rows in the table
                                    ?>
                                            <div>
                                                <table class="table table-hover table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <td>#</td>
                                                            <td>Paiement ID</td>
                                                            <td>Price</td>
                                                            <td>Date</td>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Populate the table with data from the database -->
                                                        <?php   $count=1;  while ($row = mysqli_fetch_assoc($sql2)) {?>

                                                        <tr>
                                                            <td><?php echo $count;?></td>
                                                            <td><?php echo  $row['paiementID']; ?></td>
                                                            <td><?php echo $row['price'] ;?> DT</td>
                                                            <td><?php echo $row['enrollDate'] ;?></td>

                                                            <?php 
                                                        $count++;
                                                    }?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->




    <!-- Footer Start -->
    <?php include('includes/footer.php'); ?>

    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary rounded-0 btn-lg-square back-to-top"><i
            class="fa fa-angle-double-up"></i></a>

    <!-- Include Cropper.js and its dependencies -->
    <link href="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/cropperjs/dist/cropper.min.js"></script>
    <!-- JavaScript Libraries -->


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>


    <!-- JavaScript code to initialize Cropper.js -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var image = document.getElementById('imageInput');
        var cropper;

        image.addEventListener('change', function() {
            var files = this.files;
            var reader;

            if (files && files.length) {
                reader = new FileReader();
                reader.onload = function(event) {
                    var dataUrl = event.target.result;

                    if (cropper) {
                        cropper.replace(dataUrl);
                    } else {
                        var imageElement = document.createElement('img');
                        imageElement.src = dataUrl;
                        imageElement.id = 'cropperImage';
                        document.body.appendChild(imageElement);
                        cropper = new Cropper(imageElement, {
                            aspectRatio: 1,
                            viewMode: 2,
                            crop: function(event) {
                                // Output cropped area data
                                console.log(event.detail.x);
                                console.log(event.detail.y);
                                console.log(event.detail.width);
                                console.log(event.detail.height);
                            }
                        });
                    }
                };

                reader.readAsDataURL(files[0]);
            }
        });
    });
    </script>
</body>

</html>
<?php } ?>