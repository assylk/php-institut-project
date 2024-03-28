<?php
session_start();
include('includes/config.php');
error_reporting(0);
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
  $regid=$_GET['id'];

if(isset($_POST['submit']))
{
  $regid=intval($_GET['id']);
  $studentname=$_POST['studentname'];
  $photo=$_FILES["photo"]["name"];


$cgpa=$_POST['cgpa'];
move_uploaded_file($_FILES["photo"]["tmp_name"],"studentphoto/".$_FILES["photo"]["name"]);
$ret=mysqli_query($con,"update students set studentName='$studentname',studentPhoto='$photo',cgpa='$cgpa'  where StudentRegno='$regid'");
if($ret)
{
echo '<script>alert("Student Record updated Successfully !!")</script>';
echo '<script>window.location.href=manage-students.php</script>';
}else{
  echo '<script>alert("Error : Student Record not update")</script>';
echo '<script>window.location.href=manage-students.php</script>';
}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ISMAIK BIBLIO - Edit Student</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
</head>


<body>
    <!-- Topbar Start -->
    <?php include("includes/topbar.php"); ?>
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
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <a href="courses.php" class="nav-item nav-link">Courses</a>
                    <?php if($_SESSION['alogin']!=""){ ?>

                    <a href="add-course.php" class="nav-item nav-link">Add Course</a>
                    <a href="profile.php" class="nav-item nav-link">Profile</a>
                    <?php }?>

                </div>
                <?php if($_SESSION['alogin']==""){ ?>
                <a href="index.php#login" class="btn btn-primary py-2 px-4 d-none d-lg-block">Join Us</a>
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
            <h1 class="text-white display-1">Edit Student</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="../index.php">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase"><a class="text-white" href="manage-students.php">Manage Students</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase"><a class="text-white" href="edit-student.php">Edit Student</a></p>


            </div>

        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <font color="green" align="center">
            <?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>
        <?php 
$regid=intval($_GET['id']);

$sql=mysqli_query($con,"select * from students where StudentRegno='$regid'");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{ ?>
        <div class="container py-5">
            <form name="dept" class="w-75 " method="post" enctype="multipart/form-data">
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="floatingInputInvalid" name="studentname"
                        value="<?php echo htmlentities($row['studentName']);?>" placeholder="Enter Student Name"
                        value="">
                    <label for="floatingInputInvalid">Student Name</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="floatingInputInvalid" name="studentregno"
                        value="<?php echo htmlentities($row['StudentRegno']);?>" placeholder="Student Reg no" readonly>
                    <label for="floatingInputInvalid">Student Reg No</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="floatingInputInvalid" name="Pincode" readonly
                        value="<?php echo htmlentities($row['pincode']);?>" required value="">
                    <label for="floatingInputInvalid">Pincode</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="text" class="form-control" id="floatingInputInvalid" name="cgpa"
                        value="<?php echo htmlentities($row['cgpa']);?>" required value="">
                    <label for="floatingInputInvalid">CGPA</label>
                </div>
                <div class="form-group">
                    <label for="studentphoto">Student Photo </label>
                    <?php if($row['studentPhoto']==Null){ ?>
                    <img src="img/testimonial-1.jpg" width="200" height="200"><?php } else {?>
                    <img src="img/<?php echo htmlentities($row['studentPhoto']);?>" width="200" height="200">
                    <?php } ?>
                </div>
                <div class="mb-3 form-floating">
                    <input type="file" class="form-control" id="floatingInputInvalid" placeholder="name@example.com"
                        value="">
                    <label for="floatingInputInvalid">Student Image</label>
                </div>
                <button type="submit" name="submit" id="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <?php }?>
    </div>
    <!-- About End -->





    <!-- Footer Start -->
    <?php include("includes/footer.php"); ?>
    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary rounded-0 btn-lg-square back-to-top"><i
            class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="../lib/easing/easing.min.js"></script>
    <script src="../lib/waypoints/waypoints.min.js"></script>
    <script src="../lib/counterup/counterup.min.js"></script>
    <script src="../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>

<?php } ?>