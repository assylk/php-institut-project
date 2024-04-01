<?php
session_start();
include('includes/config.php');
    // Check if a message is set in the session
if(isset($_SESSION['errmsg'])) {
    echo '<script>alert("'.$_SESSION['errmsg'].'")</script>';
    // Unset the session variable to clear the message
    unset($_SESSION['errmsg']);
}
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}


else{

    $authorID=$_SESSION['login'];
    $sql=mysqli_query($con,"select * from course where id='".$coursecode."'");

    
function generateUniqueCourseID() {
    // Prefix for the ID
    $prefix = "COURSE";

    // Generate a random string (you can customize the length as needed)
    $random_string = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 10)), 0, 10);

    // Generate a timestamp
    $timestamp = time();

    // Combine all elements to create the unique ID
    $unique_id = $prefix . "_" . $random_string . "_" . $timestamp;

    // Add a checksum to the ID
    $checksum = crc32($unique_id);
    $unique_id .= "_" . $checksum;

    return $unique_id;
}




if(isset($_POST['submit'])) {
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
            $course_id = generateUniqueCourseID();

            $coursecode=$_POST['coursecode'];
            $coursename=$_POST['coursename'];
            $coursecategory=$_POST['coursecategory'];
            $courseprice=$_POST['courseprice'];
            $image_path = $target_file;
            $ret=mysqli_query($con,"insert into course(coursePin,courseCode,courseName,author,category,price,portrait) values('$course_id','$coursecode','$coursename','$authorID','$coursecategory','$courseprice','$image_path')");
            if($ret) {
                $_SESSION['errmsg']="Course Added Successfully !";
            } else {
                $_SESSION['errmsg']="Something went wrong. Please try again!";
            }
        } else {
            $_SESSION['errmsg']="Sorry, there was an error uploading your file.";
        }
    } else {
        $_SESSION['errmsg']="No image selected.";
    }

 header("location:add-course.php");
 exit();
}




    
//Code for Insertion
if(isset($_POST['submit']))
{
    $course_id = generateUniqueCourseID();

$coursecode=$_POST['coursecode'];
$coursename=$_POST['coursename'];
$coursecategory=$_POST['coursecategory'];
$courseprice=$_POST['courseprice'];
$ret=mysqli_query($con,"insert into course(coursePin,courseCode,courseName,author,category,price) values('$course_id','$coursecode','$coursename','$authorID','$coursecategory','$courseprice')");
if($ret)
{
     $sql=mysqli_query($con,"select * from course where id='".$coursecode."'");

    while($row=mysqli_fetch_array($sql))
    { 
    $id=$row['id'];
    }


echo '<script>alert("Course Added By '.$_SESSION['sname'].' ")</script>';

}else {
    $_SESSION['errmsg']= "Error in adding the Course";
}
header("Location:add-course.php");
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ISMAIK BIBLIO - Add Course</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">
    <!-- Include the library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9">
    </script>
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
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

    <?php include("includes/topbar.php");?>
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

                    <a href="add-course.php" class="nav-item nav-link active">Add Course</a>
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
    <div class="container-fluid ">
        <div class="container">
            <form method="post" id="imageForm" enctype="multipart/form-data" class="row g-3">
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
                    <input class="form-control" id="imageInput" id="photo" name="photo" type="file"
                        id="floatingTextarea">

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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
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
    <script src="js/main.js"></script>
</body>

</html>

<?php }?>