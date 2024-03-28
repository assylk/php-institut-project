<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{
date_default_timezone_set('Africa/Tunisia');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );

//Code for Change Password
if(isset($_POST['changepass']))
{ 
$regno=$_SESSION['login'];   
$currentpass=md5($_POST['cpass']);
$newpass=md5($_POST['newpass']);
$sql=mysqli_query($con,"SELECT password FROM  students where password='$currentpass' && studentRegno='$regno'");
$num=mysqli_fetch_array($sql);
if($num>0)
{
 $con=mysqli_query($con,"update students set password='$newpass', updationDate='$currentTime' where studentRegno='$regno'");
echo '<script>alert("Password Changed Successfully !!")</script>';
echo '<script>window.location.href=change-password.php</script>';
}else{
echo '<script>alert("Current Password not match !!")</script>';
echo '<script>window.location.href=change-password.php</script>';
}
}


if(isset($_POST['submitprivate']))
{
$studentname=$_POST['studentname'];
$cgpa=$_POST['cgpa'];
$email=$_POST['email'];
$city=$_POST['city'];
$state=$_POST['state'];
$zip=$_POST['zip'];
$ret=mysqli_query($con,"update students set studentName='$studentname',email='$email',cgpa='$cgpa',city='$city',state='$state',zip='$zip'  where StudentRegno='".$_SESSION['login']."'");
if($ret)
{
echo '<script>alert("Student Record updated Successfully !!")</script>';
echo '<script>window.location.href=my-profile.php</script>';    
}else{
echo '<script>alert("Something went wrong . Please try again.!")</script>';
echo '<script>window.location.href=my-profile.php</script>';    
}
}


if(isset($_POST['submitpublic']))
{
    $t="0";
    $target_dir = "studentphoto/";
    $timestamp = time(); // Current timestamp
    $target_file = $target_dir . $timestamp . "_" . basename($_FILES["photo"]["name"]);
    // Check file size (limit to 5MB)
    $max_file_size = 5 * 1024 * 1024; // 5MB in bytes
    if ($_FILES["photo"]["size"] > $max_file_size) {
        $_SESSION['errmsg']="Sorry, your file is too large (max 5MB).";
    }
    // Check file type
    $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
    $file_extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if (!in_array($file_extension, $allowed_types)) {
        $_SESSION['errmsg']="Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }
    // Check if file already exists
    if (file_exists($target_file)) {
        $_SESSION['errmsg']="Sorry, file already exists.";
    }
    // Upload file
    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
        $t="1";
                $_SESSION['errmsg']="The file ". basename($target_file). " has been uploaded.";


        // Save file path to database
        $image_path = $target_file;
        $ret=mysqli_query($con,"update students set studentName='$studentname',studentPhoto='$image_path',bio='$bio'  where StudentRegno='".$_SESSION['login']."'");
            if($ret)
            {
            echo '<script>alert("Student Record updated Successfully !!")</script>';
            echo '<script>window.location.href=my-profile.php</script>';    
            }else{
            echo '<script>alert("Something went wrong . Please try again.!")</script>';
            echo '<script>window.location.href=my-profile.php</script>';    
            }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
$studentname=$_POST['studentname'];
$bio=$_POST['bio'];


}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ISMAIK BIBLIO - Profile</title>
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
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>
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
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <a href="index.html" class="navbar-brand ml-lg-3">
                <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-book-reader mr-3"></i>ISMAIK BIBLIO</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="courses.php" class="nav-item nav-link">Courses</a>
                    <?php if($_SESSION['login']!=""){ ?>
                    <a href="add-course.php" class="nav-item nav-link">Add Course</a>

                    <a href="profile.php" class="nav-item nav-link active">Profile</a>
                    <?php }?>

                </div>
                <?php if($_SESSION['login']==""){ ?>
                <a href="index.php" class="btn btn-primary py-2 px-4 d-none d-lg-block">Join Us</a>
                <?php }else{ ?>
                <a href="logout.php" class="btn btn-primary py-2 px-4 d-none d-lg-block">Logout</a>
                <?php }?>
            </div>
        </nav>
    </div>
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
                                        href="#account" role="tab">
                                        Account
                                    </a>
                                    <a class="list-group-item list-group-item-action" data-toggle="list"
                                        href="#password" role="tab">
                                        Password
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
                                <div class="tab-pane fade show active" id="account" role="tabpanel">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-actions float-right">
                                                <div class="dropdown show">
                                                    <a href="#" data-toggle="dropdown" data-display="static">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-more-horizontal align-middle">
                                                            <circle cx="12" cy="12" r="1"></circle>
                                                            <circle cx="19" cy="12" r="1"></circle>
                                                            <circle cx="5" cy="12" r="1"></circle>
                                                        </svg>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="card-title mb-0">Public info</h5>
                                        </div>
                                        <?php $sql=mysqli_query($con,"select * from students where StudentRegno='".$_SESSION['login']."'");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{ ?>
                                        <div class="card-body">
                                            <form name="dept" method="post" id="imageForm"
                                                enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label for="inputUsername">Username</label>
                                                            <input type="text" class="form-control" id="inputUsername"
                                                                placeholder="Username" name="studentname"
                                                                value="<?php echo htmlentities($row['studentName']);?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputUsername">Biography</label>
                                                            <textarea rows="2" class="form-control" id="inputBio"
                                                                name="bio"
                                                                placeholder="Tell something about yourself"><?php echo htmlentities($row['bio']);?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-center">
                                                            <?php if($row['studentPhoto']==""){ ?>
                                                            <img alt="Andrew Jones"
                                                                src="https://bootdey.com/img/Content/avatar/avatar1.png"
                                                                class="rounded-circle img-responsive mt-2" width="128"
                                                                height="128">
                                                            <?php } else {?>
                                                            <img src="<?php echo htmlentities($row['studentPhoto']);?>"
                                                                alt="<?php echo htmlentities($row['studentPhoto']);?>"
                                                                width="200" height="200"
                                                                style="border-radius: 50%;object-fit:cover">
                                                            <?php } ?>
                                                            <div class="mt-2">
                                                                <input type="file" id="imageInput" id="photo"
                                                                    name="photo"
                                                                    value="<?php echo htmlentities($row['studentPhoto']);?>">
                                                            </div>
                                                            <small>For best results, use an image at least 128px by
                                                                128px in .jpg format</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" name="submitpublic" class="btn btn-primary">Save
                                                    changes</button>
                                            </form>
                                        </div>
                                        <?php }?>
                                    </div>
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-actions float-right">
                                                <div class="dropdown show">
                                                    <a href="#" data-toggle="dropdown" data-display="static">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="feather feather-more-horizontal align-middle">
                                                            <circle cx="12" cy="12" r="1"></circle>
                                                            <circle cx="19" cy="12" r="1"></circle>
                                                            <circle cx="5" cy="12" r="1"></circle>
                                                        </svg>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="#">Action</a>
                                                        <a class="dropdown-item" href="#">Another action</a>
                                                        <a class="dropdown-item" href="#">Something else here</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <h5 class="card-title mb-0">Private info</h5>
                                        </div>
                                        <font color="green" align="center">
                                            <?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
                                        </font>
                                        <?php $sql=mysqli_query($con,"select * from students where StudentRegno='".$_SESSION['login']."'");
                                        $cnt=1;
                                        while($row=mysqli_fetch_array($sql))
                                        { ?>
                                        <div class="card-body">
                                            <form name="dept" method="post" enctype="multipart/form-data">
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputFirstName">Student Name</label>
                                                        <input type="text" class="form-control" id="inputFirstName"
                                                            placeholder="First name" id="studentname" name="studentname"
                                                            value="<?php echo htmlentities($row['studentName']);?>">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="inputLastName">Student Reg No</label>
                                                        <input type="text" class="form-control" disabled
                                                            id="inputLastName" placeholder="Reg No" id="studentregno"
                                                            name="studentregno"
                                                            value="<?php echo htmlentities($row['StudentRegno']);?>">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputEmail4">Email</label>
                                                    <input type="email" class="form-control" id="inputEmail4"
                                                        placeholder="Email" name="email"
                                                        value="<?php echo htmlentities($row['email']);?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputAddress">Pincode</label>
                                                    <input type="text" class="form-control" id="inputAddress"
                                                        id="Pincode" name="Pincode" placeholder="Pincode" readonly
                                                        value="<?php echo htmlentities($row['pincode']);?>">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputAddress2">CGPA </label>
                                                    <input type="text" class="form-control" id="cgpa" name="cgpa"
                                                        id="inputAddress2" placeholder="CGPA"
                                                        value="<?php echo htmlentities($row['cgpa']);?>">
                                                </div>
                                                <div class="form-row">
                                                    <div class="form-group col-md-6">
                                                        <label for="inputCity">City</label>
                                                        <input type="text" name="city"
                                                            value="<?php echo htmlentities($row['city']);?>"
                                                            class="form-control" id="inputCity">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="inputState">State</label>
                                                        <select id="inputState" name="state" class="form-control">
                                                            <option
                                                                selected="<?php echo htmlentities($row['state']);?>">
                                                                <?php echo htmlentities($row['state']);?></option>
                                                            <option value="Sousse">Sousse</option>
                                                            <option value="Monastir">Monastir</option>
                                                            <option value="Mehdia">Mehdia</option>
                                                            <option value="Kairouan">Kairouan</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label for="inputZip">Zip</label>
                                                        <input type="text"
                                                            value="<?php echo htmlentities($row['zip']);?>" name="zip"
                                                            class="form-control" id="inputZip">
                                                    </div>
                                                </div>
                                                <button type="submit" name="submitprivate" class="btn btn-primary">Save
                                                    changes</button>
                                            </form>
                                        </div>
                                        <?php }?>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="password" role="tabpanel">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">Password</h5>
                                            <form name="chngpwd" method="post" onSubmit="return valid();">
                                                <div class="form-group">
                                                    <label for="inputPasswordCurrent">Current password</label>
                                                    <input type="password" name="cpass"
                                                        placeholder="Enter Your current Password" class="form-control"
                                                        id="inputPasswordCurrent">
                                                    <small><a href="#">Forgot your password?</a></small>
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputPasswordNew">New password</label>
                                                    <input type="password" name="newpass" class="form-control"
                                                        placeholder="Enter Your new Password" id="inputPasswordNew">
                                                </div>
                                                <div class="form-group">
                                                    <label for="inputPasswordNew2">Verify password</label>
                                                    <input type="password" name="cnfpass" class="form-control"
                                                        placeholder="Confirm Your new Password" id="inputPasswordNew2">
                                                </div>
                                                <button type="submit" name="changepass" class="btn btn-primary">Save
                                                    changes</button>
                                            </form>
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
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>


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