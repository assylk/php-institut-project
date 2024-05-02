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
    $courseName=$row['courseName'];
    $price=$row['price'];
    $rate=$row['rate'];
    $thumbnail=$row['thumbnail'];
    $courseUnit=$row['courseUnit'];
    $coursePin=$row['coursePin'];
    $rate=$row['rate'];
    $language=$row['language'];
    $description=$row['description'];
    $skillvl=$row['skillvl'];
}

$sql=mysqli_query($con,"select * from students where StudentRegno='".$authorID."'");
while($row=mysqli_fetch_array($sql))
{
    $author=$row['studentName'];

}


if(isset($_POST['submitpublic'])) {
    $target_dir = "thumbnailimg/";

    // Check if a file is selected
    if($_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
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
            // Save file path to database
            $image_path = $target_file;
            $ret = mysqli_query($con,"UPDATE course SET thumbnail='$image_path' WHERE id='".$id."'");
            if($ret) {
                $_SESSION['errmsg']="Thumbnail Image updated Successfully !!";
            } else {
                $_SESSION['errmsg']="Something went wrong. Please try again!";
            }
        } else {
            $_SESSION['errmsg']="Sorry, there was an error uploading your file.";
        }
    } else {
        $_SESSION['errmsg']="No image selected.";
    }

 header("location:detail.php?id=$id");
 exit();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Connect Courses - Detail</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
        integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
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
<style>
.rating {
    font-size: 30px;
}

.star {
    cursor: pointer;
}

.star:hover,
.star.active {
    color: gold;
}
</style>
<body>
    <!-- Topbar Start -->
    <?php include('includes/topbar.php'); ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <a href="index.php" class="navbar-brand ml-lg-3">
                <img src="img/logo2.png" alt="Logo" style="width: 250px;">
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
                    <a href="profile.php" class="nav-item nav-link">Profile</a>
                    <a href="logout.php" class="nav-item nav-link" style="color:red">Logout</a>
                    <?php }?>

                </div>

                <?php if($_SESSION['login']!=""){ ?>
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
                    <form name="dept" method="post" id="imageForm" enctype="multipart/form-data">
                        <div class="mb-5">
                            <div class="section-title position-relative mb-5">
                                <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Course
                                    Detail</h6>
                                <h1 class="display-4"><?php echo $courseName ?></h1>
                            </div>
                            <?php if($thumbnail==Null && $author==$_SESSION['sname']){ ?>
                            <img id="imgFileUpload" class="img-fluid rounded w-100 mb-4" alt="Select File"
                                title="Select File" src="img/addimage.png" style="cursor: pointer" />
                            <span id="spnFilePath"></span>
                            <input type="file" id="imageInput" id="photo" name="photo" style="display: none" />
                            <?php }else if($thumbnail==Null && $author!=$_SESSION['sname']){?>
                            <img id="imgFileUpload" class="img-fluid rounded w-100 mb-4" alt="Thumbnail"
                                src="img/notavailable.png" />
                            <?php }else if($thumbnail!=Null){?>
                            <img id="imgFileUpload" class="img-fluid rounded w-100 mb-4" alt="Thumbnail"
                                src="<?php echo $thumbnail; ?>" />
                            <?php }?>

                            <?php if($thumbnail==Null && $author==$_SESSION['sname']){ ?>
                            <button type="submit" name="submitpublic" class="btn btn-primary">Save
                                changes</button>
                            <?php }?>
                            <p><?php echo $description ?></p>
                        </div>
                    </form>
                    <h2 class="mb-3">Related Courses</h2>
                    <?php  $sql=mysqli_query($con,"select c.portrait as portrait,c.id as courseID,c.courseUnit as courseUnit,c.rate as rate,c.courseName AS courseName,c.author,s.studentName AS author_name from course c  INNER JOIN students s ON c.author = s.StudentRegno where c.category='".$category."' and c.id!='$id'");
                        if(mysqli_num_rows($sql)==0){                ?>
                    <p>No Related Course Foundd</p>
                    <?php }else{?>
                    <div class="owl-carousel related-carousel position-relative" style="padding: 0 30px;">
                        <?php while ($row = mysqli_fetch_assoc($sql)){ ?>
                        <a class="courses-list-item position-relative d-block overflow-hidden mb-2"
                            href="detail.php?id=<?php echo $row['courseID'];?>">
                            <img class="img-fluid" style="height:400px;object-fit:cover"
                                src="<?php echo $row['portrait'];?>" alt="">
                            <div class="courses-text">
                                <h4 class="text-center text-white px-3"><?php echo $row['courseName']?></h4>
                                <div class="border-top w-100 mt-3">
                                    <div class="d-flex justify-content-between p-4">
                                        <span class="text-white"><i
                                                class="fa fa-user mr-2"></i><?php echo $row['author_name'];?></span>
                                        <span class="text-white"><i
                                                class="fa fa-star mr-2"></i><?php echo $row['rate'];?>
                                            <small>(<?php echo $row['courseUnit'];?>)</small></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                        <?php }?>
                    </div>
                    <?php }?>
                </div>

                <div class="col-lg-4 mt-5 mt-lg-0">



                    <div class="bg-primary mb-5 py-3">
                        <h3 class="text-white py-3 px-4 m-0">Course Features</h3>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Instructor</h6>
                            <h6 class="text-white my-3"><?php echo $author;?></h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Rating</h6>
                            <h6 class="text-white my-3">4.5 <small>(<?php echo $rate?>)</small></h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Lectures</h6>
                            <h6 class="text-white my-3"> <?php echo $courseUnit?></h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Duration</h6>
                            <h6 class="text-white my-3">10.00 Hrs</h6>
                        </div>
                        <div class="d-flex justify-content-between border-bottom px-4">
                            <h6 class="text-white my-3">Skill level</h6>
                            <h6 class="text-white my-3"><?php echo $skillvl ?></h6>
                        </div>
                        <div class="d-flex justify-content-between px-4">
                            <h6 class="text-white my-3">Language</h6>
                            <h6 class="text-white my-3"><?php echo $language ?></h6>
                        </div>
                        <h5 class="text-white py-3 px-4 m-0">Course Price: <?php echo $price;?> DT
                        </h5>
                        <div class="py-3 px-4">
                            <a class="btn btn-block btn-secondary py-3 px-5"
                                href="flousi.php?amount=<?php echo $price;?>&&coursepin=<?php echo $coursePin;?>&&studentID=<?php echo $authorID;?>">Enroll
                                Now</a>
                        </div>


                    </div>
                    <div class="rating" id="rating">
                        <span class="star" data-value="1">&#9733;</span>
                        <span class="star" data-value="2">&#9733;</span>
                        <span class="star" data-value="3">&#9733;</span>
                        <span class="star" data-value="4">&#9733;</span>
                        <span class="star" data-value="5">&#9733;</span>
                    </div>


                    <div class="mb-5">
                        <h2 class="mb-3">Categories</h2>
                        <ul class="list-group list-group-flush">
                            <?php 
                                    $sql=mysqli_query($con,"select * from category");
                                    $cnt=1;
                                    if(mysqli_num_rows($sql) ==0){?>
                            <li class="list-group-item text-center font-weight-bold ">No Category Found!</li>
                            <?php }else{
                while($row=mysqli_fetch_array($sql))
                { ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <a href=""
                                    class="text-decoration-none h6 m-0"><?php echo htmlentities($row['nameCat']);?></a>
                                <span class="badge badge-primary badge-pill">150</span>
                            </li>
                            <?php }}?>

                        </ul>
                    </div>

                    <div class="mb-5">
                        <h2 class="mb-4">Recent Courses</h2>

                        <?php 
                                    $sql=mysqli_query($con,"select * from course where author='".$authorID."' and id!='$id' LIMIT 4");
                                    if(mysqli_num_rows($sql)==0){?>
                        <p>No Data Found.</p>
                        <?php
                                }else{
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
                        <?php }}?>

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

    <script>
    const stars = document.querySelectorAll('.star');

    stars.forEach(star => {
        star.addEventListener('click', () => {
            const value = parseInt(star.getAttribute('data-value'));

            // Remove active class from all stars
            stars.forEach(s => s.classList.remove('active'));

            // Add active class to the clicked star and all stars before it
            for (let i = 0; i < value; i++) {
                stars[i].classList.add('active');
            }

            // Send rating value to the server
            sendRating(value);
        });

        star.addEventListener('mouseenter', () => {
            const value = parseInt(star.getAttribute('data-value'));

            // Add hover effect to all stars before the hovered one
            for (let i = 0; i < value; i++) {
                stars[i].classList.add('active');
            }
        });

        star.addEventListener('mouseleave', () => {
            // Remove hover effect from all stars
            stars.forEach(s => s.classList.remove('active'));
        });
    });

    function sendRating(value) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'save_rating.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    console.log('Rating saved successfully');
                } else {
                    console.error('Error saving rating:', xhr.status);
                }
            }
        };
        xhr.send('rating=' + encodeURIComponent(value));
    }
    </script>
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
        var fileupload = $("#imageInput");
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