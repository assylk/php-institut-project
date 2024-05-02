<?php
session_start();
include('includes/config.php');
error_reporting(0);

if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}else{
$a = $_GET['id'];
// Check if a message is set in the session
if(isset($_SESSION['message'])) {
    echo '<script>alert("'.$_SESSION['message'].'")</script>';
    // Unset the session variable to clear the message
    unset($_SESSION['message']);
}
        // Retrieve existing values from the database
$existing_course = mysqli_query($con, "SELECT * FROM course WHERE id='$a'");
$row = mysqli_fetch_assoc($existing_course);
$existing_courseName = $row['courseName'];
$existing_price = $row['price'];
$existing_description = $row['description'];
$existing_skillvl = $row['skillvl'];
$existing_category = $row['category'];
$scat=mysqli_query($con,"select nameCat from category where id='$existing_category'");
while($r=mysqli_fetch_assoc($scat)){
    $cat= $r["nameCat"]; 
}

    date_default_timezone_set("Africa/Tunis");
    $date=date("Y-m-d h:i:s");

    
    if (isset($_POST['editCourse'])) {
        // Check if there are changes
        // Retrieve submitted values
        $courseName = $_POST['courseName'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        $skillvl = $_POST['skillvl'];
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



    // If there are changes, update the database
    if (!empty($changes)) {
        $update_query = "UPDATE course SET " . implode(', ', $changes) . ",updationDate='$date' WHERE id='$a'";
        $result = mysqli_query($con, $update_query);
        if ($result) {
            $_SESSION['message']="Course Updated Successfully";
        } else {
            $_SESSION['message']="Course Not Updated";
        }
        } else {
            $_SESSION['message']="No changes detected.";
        }
        header("Location: edit-course.php?id=$a");
        
    }






?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>ISMAIK BIBLIO - Edit Course</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon" />

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link
        href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap"
        rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet" />

    <!-- Libraries Stylesheet -->
    <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/style.css" rel="stylesheet" />
</head>

<body>
    <!-- Topbar Start -->
    <?php include("includes/topbar.php"); ?>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <?php include("includes/navbar.php"); ?>
    <!-- Navbar End -->

    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid page-header position-relative overlay-bottom" style="margin-bottom: 90px">
        <div class="container text-center py-5">
            <h1 class="text-white display-1">Edit</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase">
                    <a class="text-white" href="">Home</a>
                </p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">
                    <a class="text-white" href="manage-courses.php">Manage Courses</a>
                </p>
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
                <font color="green" align="center">
                    <?php echo htmlentities($_SESSION['msg']);?><?php echo htmlentities($_SESSION['msg']="");?></font>

                <div class="container py-5">
                    <form class="w-75 " method="post">
                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" id="floatingInputValue"
                                placeholder="Enter Course Name" name="courseName"
                                value="<?php echo $existing_courseName ?>">
                            <label for="floatingInputValue">Course Name</label>
                        </div>
                        <div class="mb-3 form-floating">
                            <select class="form-select" name="category" id="floatingSelect"
                                aria-label="Floating label select example">
                                <option selected value="<?php echo $existing_category ?>"><?php echo $cat ?>
                                </option>
                                <?php $sql=mysqli_query($con,"SELECT * FROM category where id!='$existing_category'");  
                            while($row=mysqli_fetch_array($sql)){
                            ?>
                                <option value="<?php echo $row['id']; ?>"><?php echo $row['nameCat']; ?>
                                    <?php }?>

                            </select>
                            <label for="floatingSelect">Works with selects</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select class="form-select" id="floatingSelect" name="skillvl"
                                aria-label="Floating label select example">
                                <option selected value="<?php echo $existing_skillvl ?>"><?php echo $existing_skillvl ?>
                                </option>
                                <option value="Regular">Regular</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                            </select>
                            <label for="floatingSelect">Works with selects</label>
                        </div>

                        <div class="mb-3 form-floating">
                            <input type="text" class="form-control" name="price" id="floatingInputValue"
                                placeholder="Enter Course Price" value="<?php echo $existing_price; ?>">
                            <label for="floatingInputValue">Course Price</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" name="description" placeholder="Enter Course Description"
                                id="floatingTextarea2"
                                style="height: 100px"><?php echo $existing_description ?></textarea>
                            <label for="floatingTextarea2">Description</label>
                        </div>



                        <button type="submit" name="editCourse" id="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
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

    <!-- Template Javascript -->
    <script src="../js/main.js"></script>
</body>
</html>



<?php }?>