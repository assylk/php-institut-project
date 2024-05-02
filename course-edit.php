<?php

session_start();
include('includes/config.php');
// Check if a message is set in the session
if(isset($_SESSION['message'])) {
    echo '<script>alert("'.$_SESSION['message'].'")</script>';
    // Unset the session variable to clear the message
    unset($_SESSION['message']);
}
$a = $_GET['id'];
    // Retrieve existing values from the database
$existing_course = mysqli_query($con, "SELECT * FROM course WHERE coursePin='$a'");
$row = mysqli_fetch_assoc($existing_course);
$existing_courseName = $row['courseName'];
$existing_price = $row['price'];
$existing_category = $row['category'];
$existing_description = $row['description'];
$existing_skillvl = $row['skillvl'];
$existing_language = $row['language'];
$existing_thumbnail = $row['thumbnail'];

$scat=mysqli_query($con,"select nameCat from category where id=".$existing_category);
while($r=mysqli_fetch_assoc($scat)){
    $cat= $r["nameCat"]; 
}
if(isset($_POST['submit'])) {





    
// Retrieve submitted values
$courseName = $_POST['courseName'];
$price = $_POST['price'];
$category = $_POST['category'];
$description = $_POST['description'];

$skillvl = $_POST['skillvl'];
$language = $_POST['language'];
$thumbnail = $_POST['thumbnail'];












$target_dir = "studentphoto/";

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
            $ret = mysqli_query($con,"UPDATE course SET thumbnail='$image_path' WHERE coursePin='$a'");
            if($ret) {
                $_SESSION['errmsg']="Image updated Successfully !!";
            } else {
                $_SESSION['errmsg']="Something went wrong. Please try again!";
            }
        } else {
            $_SESSION['errmsg']="Sorry, there was an error uploading your file.";
        }
    } else {
        $_SESSION['errmsg']="No image selected.";
    }



    date_default_timezone_set("Africa/Tunis");
    $date=date("Y-m-d h:i:s");



// Check if there are changes
$changes = array();
if ($existing_courseName != $courseName) {
    $changes[] = "courseName='$courseName'";
}

if ($existing_price != $price) {
    $changes[] = "price='$price'";
}
if ($existing_category != $category) {
    $changes[] = "category='$category'";
}
if ($existing_description != $description) {
    $changes[] = "description='$description'";
}
if ($existing_skillvl != $skillvl) {
    $changes[] = "skillvl='$skillvl'";
}
if ($existing_language != $language) {
    $changes[] = "language='$language'";
}
if ($existing_thumbnail != $thumbnail) {
    $changes[] = "thumbnail='$thumbnail'";
}


// If there are changes, update the database
if (!empty($changes)) {
    $update_query = "UPDATE course SET " . implode(', ', $changes) . ",updationDate='$date' WHERE coursePin='$a'";
    $result = mysqli_query($con, $update_query);
    if ($result) {
        $_SESSION['message']= 'Course updated successfully!'; 
    } else {
        $_SESSION['error']= 'Error updating course: '.mysqli_error($con).'. Please try again later.'; 
    }
} else {
    $_SESSION['message']= 'No changes made to this course.'; 
}

    header("location:course-edit.php?id=$a");
    //exit();
}
 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connect Courses - Edit Course</title>
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</head>
<body>

    <!-- Topbar Start -->
    <?php include("includes/topbar.php"); ?>
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
                    <a href="courses.php" class="nav-item nav-link active">Courses</a>
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
            <h1 class="text-white display-1">Edit</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="profile.php">Profile</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Edit Course</p>
            </div>
        </div>
    </div>
    <!-- Header End -->
    <!-- About Start -->
    <div class="container-fluid">
        <div class="container">
            <div class="row">
                <form class="row g-3" method="post">

                    <div class="form-floating col-md-6 mb-2">
                        <input type="text" class="form-control" value="<?php echo $existing_courseName;?>"
                            name="courseName" id="floatingInput" placeholder="Enter Course Name">
                        <label for="floatingInput">Course Name</label>
                    </div>

                    <div class="form-floating col-md-6 mb-3">
                        <input type="text" class="form-control" value="<?php echo $existing_price;?>" name="price"
                            id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Course Price</label>
                    </div>


                    <div class="form-floating mb-3 col-12">

                        <textarea class="form-control" placeholder="Enter Course Description" name="description"
                            id="exampleFormControlTextarea1" rows="3"><?php echo $existing_description ?></textarea>
                        <label for="exampleFormControlTextarea1" class="form-label">Course Description</label>
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">Category</label>
                        <select id="inputState" name="category" class="form-select">
                            <option selected value="<?php echo $existing_category ?>"><?php echo $cat ?>
                            </option>
                            <?php $sql=mysqli_query($con,"SELECT * FROM category where id!='$existing_category'");  
                            while($row=mysqli_fetch_array($sql)){
                            ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nameCat']; ?>
                            </option>
                            <?php }?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">Skill Level</label>
                        <select id="inputState" name="skillvl" class="form-select">
                            <option selected="selected" value="<?php echo  $existing_skillvl ?>">
                                <?php echo  $existing_skillvl ?></option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="inputState" class="form-label">Course Language</label>
                        <select id="inputState" name="language" class="form-select">
                            <option selected value="<?php echo  $existing_language ?>"><?php echo  $existing_language ?>
                            </option>
                            <option value="Arabic">Arabic</option>
                            <option value="English">English</option>
                            <option value="French">French</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <button type="submit" name="submit" class="btn btn-primary">Sign in</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- About End -->
    <?php include("includes/footer.php") ?>
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
    <!-- JavaScript code to initialize Cropper.js -->

</body>
</html>