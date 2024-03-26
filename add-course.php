<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{
    $username=$_SESSION['sname'];

//Code for Insertion
if(isset($_POST['submit']))
{
$coursecode=$_POST['coursecode'];
$coursename=$_POST['coursename'];
$coursecategory=$_POST['coursecategory'];
$courseprice=$_POST['courseprice'];
$ret=mysqli_query($con,"insert into course(courseCode,courseName,author,category,price) values('$coursecode','$coursename','$username','$coursecategory','$courseprice')");
if($ret)
{
     $sql=mysqli_query($con,"select * from course where id='".$coursecode."'");

    while($row=mysqli_fetch_array($sql))
    { 
    $id=$row['id'];
    }
echo '<script>alert("Course Created Successfully !!")</script>';
header("location:detail.php?id=".$id);
}else {
echo '<script>alert("Error : Course not created!!")</script>';
echo '<script>window.location.href=course.php</script>';
}
}

//Code for Insertion
if(isset($_GET['del']))
{
mysqli_query($con,"delete from course where id = '".$_GET['id']."'");
echo '<script>alert("Course deleted!!")</script>';
echo '<script>window.location.href=course.php</script>';
      }
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Edukate - Online Education Website Template</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid bg-dark">
        <div class="row py-2 px-lg-5">
            <div class="col-lg-6 text-center text-lg-left mb-2 mb-lg-0">
                <div class="d-inline-flex align-items-center text-white">
                    <small><i class="fa fa-phone-alt mr-2"></i>+012 345 6789</small>
                    <small class="px-3">|</small>
                    <small><i class="fa fa-envelope mr-2"></i>info@example.com</small>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <a class="text-white px-2" href="">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-white px-2" href="">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-white px-2" href="">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-white px-2" href="">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a class="text-white pl-2" href="">
                        <i class="fab fa-youtube"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <a href="index.html" class="navbar-brand ml-lg-3">
                <h1 class="m-0 text-uppercase text-primary"><i class="fa fa-book-reader mr-3"></i>Edukate</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link">Home</a>
                    <a href="courses.php" class="nav-item nav-link">Courses</a>
                    <?php if($_SESSION['login']!=""){ ?>

                    <a href="add-course.php" class="nav-item nav-link active">Add Course</a>
                    <a href="profile.php" class="nav-item nav-link">Profile</a>
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
            <h1 class="text-white display-1">Add Course</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="index.php">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Add Course</p>
            </div>

        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <form method="post" class="row g-3">
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" name="coursename" placeholder="Enter Course Name"
                            id="floatingTextarea" required>
                        <label for="floatingTextarea">Course Name</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" name="coursecode" placeholder="Enter Course Name"
                            id="floatingTextarea" required>
                        <label for="floatingTextarea">Course Code</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <select class="form-select" name="coursecategory" id="floatingSelectGrid" required>
                            <option selected value="">Select Course Category</option>
                            <?php $sql=mysqli_query($con,"select * from category");
                                    $cnt=1;
                                    while($row=mysqli_fetch_array($sql))
                                    { ?>
                            <option value="<?php echo htmlentities($row['id']);?>">
                                <?php echo htmlentities($row['nameCat']);?></option>
                            <?php }?>

                        </select>
                        <label for="floatingSelectGrid">Select Course Category</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating">
                        <input class="form-control" type="number" name="courseprice" placeholder="Enter Course Price"
                            id="floatingTextarea" pattern="[0-9]+" required>
                        <label for="floatingTextarea">Course Price</label>
                    </div>
                </div>
                <div class="col-md-12">
                    <input type="submit" name="submit" class="btn btn-primary w-100" value="Next">
                </div>
            </form>
        </div>
    </div>
    <!-- About End -->





    <!-- Footer Start -->
    <?php include('includes/footer.php'); ?>

    <!-- Footer End -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-lg btn-primary rounded-0 btn-lg-square back-to-top"><i
            class="fa fa-angle-double-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>

<?php }?>