<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
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
    <title>ISMAIK BIBLIO - Manage Courses</title>
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
            <h1 class="text-white display-1">Manage Students</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Manage Students</p>
            </div>

        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">

            <div class="row">

                <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-head-line">Course </h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Course
                            </div>
                            <font color="green" align="center">
                                <?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?>
                            </font>


                            <div class="panel-body">
                                <form name="dept" method="post">
                                    <div class="form-group">
                                        <label for="coursecode">Course Code </label>
                                        <input type="text" class="form-control" id="coursecode" name="coursecode"
                                            placeholder="Course Code" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="coursename">Course Name </label>
                                        <input type="text" class="form-control" id="coursename" name="coursename"
                                            placeholder="Course Name" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="courseunit">Course unit </label>
                                        <input type="text" class="form-control" id="courseunit" name="courseunit"
                                            placeholder="Course Unit" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="seatlimit">Seat limit </label>
                                        <input type="text" class="form-control" id="seatlimit" name="seatlimit"
                                            placeholder="Seat limit" required />
                                    </div>

                                    <button type="submit" name="submit" class="btn btn-default">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
                <font color="red" align="center">
                    <?php echo htmlentities($_SESSION['delmsg']);?><?php echo htmlentities($_SESSION['delmsg']="");?>
                </font>
                <div class="col-md-12">
                    <!--    Bordered Table  -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Course
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Course Code</th>
                                            <th>Course Name </th>
                                            <th>Course Unit</th>
                                            <th>Seat limit</th>
                                            <th>Creation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
$sql=mysqli_query($con,"select * from course");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['courseCode']);?></td>
                                            <td><?php echo htmlentities($row['courseName']);?></td>
                                            <td><?php echo htmlentities($row['courseUnit']);?></td>
                                            <td><?php echo htmlentities($row['noofSeats']);?></td>
                                            <td><?php echo htmlentities($row['creationDate']);?></td>
                                            <td>
                                                <a href="edit-course.php?id=<?php echo $row['id']?>">
                                                    <button class="btn btn-primary"><i class="fa fa-edit "></i>
                                                        Edit</button> </a>
                                                <a href="course.php?id=<?php echo $row['id']?>&del=delete"
                                                    onClick="return confirm('Are you sure you want to delete?')">
                                                    <button class="btn btn-danger">Delete</button>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php 
$cnt++;
} ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!--  End  Bordered Table  -->
                </div>
            </div>
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
</body>

</html>

<?php } ?>