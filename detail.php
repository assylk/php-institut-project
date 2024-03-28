<?php
session_start();
error_reporting(0);
include("includes/config.php");
$id=intval($_GET['id']);
$suser=$_SESSION['login'];

$sql=mysqli_query($con,"select * from course where id='".$id."'");
while($row=mysqli_fetch_array($sql))
{
    $category=$row['category'];
    $authorID=$row['author'];
}

$sql=mysqli_query($con,"select * from students where StudentRegno='".$authorID."'");
while($row=mysqli_fetch_array($sql))
{
    $author=$row['studentName'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ISMAIK BIBLIO - Detail</title>
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
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

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
                    <a href="courses.php" class="nav-item nav-link active">Courses</a>
                    <?php if($_SESSION['login']!=""){ ?>

                    <a href="add-course.php" class="nav-item nav-link">Add Course</a>
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
            <h1 class="text-white display-1">Course Detail</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="index.php">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase"><a class="text-white" href="courses.php">Courses</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase"><a class="text-white" href="detail.php?id=<?php echo $id; ?>">Course
                        Detail</a></p>
            </div>

        </div>
    </div>
    <!-- Header End -->


    <!-- Detail Start -->
    <div class="container-fluid py-5">


        <div class="container py-5">
            <div class="row">
                <div class="col-lg-8">
                    <?php 
                                    $sql=mysqli_query($con,"select * from course where id='".$id."'");
                                    $cnt=1;
                while($row=mysqli_fetch_array($sql))
                { ?>
                    <div class="mb-5">
                        <div class="section-title position-relative mb-5">
                            <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Course
                                Detail</h6>
                            <h1 class="display-4"><?php echo $row['courseName'] ?></h1>
                        </div>
                        <?php if($row['thumbnail']==Null && $row['author']==$_SESSION['sname']){ ?>
                        <img id="imgFileUpload" class="img-fluid rounded w-100 mb-4" alt="Select File"
                            title="Select File" src="img/addimage.png" style="cursor: pointer" />
                        <span id="spnFilePath"></span>
                        <input type="file" id="FileUpload1" style="display: none" />
                        <?php }else if($row['thumbnail']==Null && $row['author']!=$_SESSION['sname']){?>
                        <img id="imgFileUpload" class="img-fluid rounded w-100 mb-4" alt="Thumbnail"
                            src="img/notavailable.png" />
                        <?php }else if($row['thumbnail']!=Null){?>
                        <img id="imgFileUpload" class="img-fluid rounded w-100 mb-4" alt="Thumbnail"
                            src="img/header.jpg" />
                        <?php }?>
                        <p>Tempor erat elitr at rebum at at clita aliquyam consetetur. Diam dolor diam ipsum et, tempor
                            voluptua sit consetetur sit. Aliquyam diam amet diam et eos sadipscing labore. Clita erat
                            ipsum et lorem et sit, sed stet no labore lorem sit. Sanctus clita duo justo et tempor
                            consetetur takimata eirmod, dolores takimata consetetur invidunt magna dolores aliquyam
                            dolores dolore. Amet erat amet et magna</p>

                        <p>Sadipscing labore amet rebum est et justo gubergren. Et eirmod ipsum sit diam ut magna lorem.
                            Nonumy vero labore lorem sanctus rebum et lorem magna kasd, stet amet magna accusam
                            consetetur eirmod. Kasd accusam sit ipsum sadipscing et at at sanctus et. Ipsum sit
                            gubergren dolores et, consetetur justo invidunt at et aliquyam ut et vero clita. Diam sea
                            sea no sed dolores diam nonumy, gubergren sit stet no diam kasd vero.</p>
                    </div>
                    <?php }?>
                    <h2 class="mb-3">Related Courses</h2>
                    <div class="owl-carousel related-carousel position-relative" style="padding: 0 30px;">
                        <?php 
                                    $sql=mysqli_query($con,"select * from course where category='".$category."'");
                                    $cnt=1;
                while($row=mysqli_fetch_array($sql))
                { ?>
                        <a class="courses-list-item position-relative d-block overflow-hidden mb-2"
                            href="detail.php?id=<?php echo $row['id'];?>">
                            <img class="img-fluid" src="img/courses-1.jpg" alt="">
                            <div class="courses-text">
                                <h4 class="text-center text-white px-3"><?php echo $row['courseName'];?></h4>
                                <div class="border-top w-100 mt-3">
                                    <div class="d-flex justify-content-between p-4">
                                        <span class="text-white"><i
                                                class="fa fa-user mr-2"></i><?php echo $row['author'];?></span>
                                        <span class="text-white"><i
                                                class="fa fa-star mr-2"></i><?php echo $row['rate'];?>
                                            <small>(<?php echo $row['courseUnit'];?>)</small></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php }?>
                    </div>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">
                    <?php 
                                    $sql=mysqli_query($con,"select * from course where id='".$id."'");
                                    $cnt=1;
                while($row=mysqli_fetch_array($sql))
                { 


                    ?>
                    <div class="bg-primary mb-5 py-3">
                        <h3 class="text-white py-3 px-4 m-0">Course Features</h3>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Instructor</h6>
                            <h6 class="text-white my-3"><?php echo $author;?></h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Rating</h6>
                            <h6 class="text-white my-3">4.5 <small>(<?php echo $row['courseUnit'] ?>)</small></h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Lectures</h6>
                            <h6 class="text-white my-3"> <?php echo $row['courseUnit'] ?></h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Duration</h6>
                            <h6 class="text-white my-3">10.00 Hrs</h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Skill level</h6>
                            <h6 class="text-white my-3">All Level</h6>
                        </div>
                        <div class="d-flex justify-content-between px-4">
                            <h6 class="text-white my-3">Language</h6>
                            <h6 class="text-white my-3"></h6>
                        </div>
                        <h5 class="text-white py-3 px-4 m-0">Course Price: <?php echo htmlentities($row['price']);?> DT
                        </h5>
                        <div class="py-3 px-4">
                            <a class="btn btn-block btn-secondary py-3 px-5"
                                href="flousi.php?amount=<?php echo htmlentities($row['price']);?>&&coursepin=<?php echo htmlentities($row['coursePin']);?>&&studentID=<?php echo htmlentities($suser);?>">Enroll
                                Now</a>
                        </div>
                    </div>
                    <?php 
                    $cnt++;
                }?>


                    <div class="mb-5">
                        <h2 class="mb-3">Categories</h2>
                        <ul class="list-group list-group-flush">
                            <?php 
                                    $sql=mysqli_query($con,"select * from category");
                                    $cnt=1;
                while($row=mysqli_fetch_array($sql))
                { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <a href=""
                                    class="text-decoration-none h6 m-0"><?php echo htmlentities($row['nameCat']);?></a>
                                <span class="badge badge-primary badge-pill">150</span>
                            </li>
                            <?php }?>

                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="mb-4">Recent Courses</h2>

                        <?php 
                                    $sql=mysqli_query($con,"select * from course where author='".$author."' LIMIT 4");
                                    $cnt=1;
                while($row=mysqli_fetch_array($sql))
                { ?>
                        <a class="d-flex align-items-center text-decoration-none mb-4"
                            href="detail.php?id=<?php echo $row['id'];?>">
                            <img class="img-fluid rounded" src="img/courses-80x80.jpg" alt="">
                            <div class="pl-3">
                                <h6><?php echo $row['courseName'];?></h6>
                                <div class="d-flex">
                                    <small class="text-body mr-3"><i
                                            class="fa fa-user text-primary mr-2"></i><?php echo $row['author'];?></small>
                                    <small class="text-body"><i
                                            class="fa fa-star text-primary mr-2"></i><?php echo $row['rate'];?>
                                        (<?php echo $row['courseUnit'];?>)</small>
                                </div>
                            </div>
                        </a>
                        <?php }?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->


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
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript">
    $(function() {
        var fileupload = $("#FileUpload1");
        var filePath = $("#spnFilePath");
        var image = $("#imgFileUpload");
        image.click(function() {
            fileupload.click();
        });
        fileupload.change(function() {
            var fileName = $(this).val().split('\\')[$(this).val().split('\\').length - 1];
            filePath.html("<b>Selected File: </b>" + fileName);
        });
    });
    </script>
</body>

</html>