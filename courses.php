<?php
session_start();
error_reporting(0);
include("includes/config.php");
// Define number of records per page
$records_per_page = 3;

// Get total number of records
$sql_count = "SELECT COUNT(*) as total FROM course";
$result_count = mysqli_query($con, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];

// Calculate total number of pages
$total_pages = ceil($total_records / $records_per_page);


// Handle search
$search = "";
$cat="";
if (isset($_POST['search'])) {
    $cat = $_POST['category'];
    $search = mysqli_real_escape_string($con, $_POST['search']);
}

// Determine current page number
if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = intval($_GET['page']);
} else {
    $current_page = 1;
}

// Calculate SQL LIMIT starting number for the results on the displaying page
$start = ($current_page - 1) * $records_per_page;

// Fetch records for the current page
$sql = "SELECT course.*, students.studentName AS author_name FROM course INNER JOIN students ON course.author = students.StudentRegno";
if (empty($cat)) {
    $sql .= " WHERE courseName LIKE '%$search%' OR author LIKE '%$search%' OR courseCode LIKE '%$search%'";
}
if (!empty($search)&&!empty($cat)) {
    $sql .= " WHERE (courseName LIKE '%$search%' OR author LIKE '%$search%' OR courseCode LIKE '%$search%') and category='$cat'";
}
$sql .= " LIMIT $start, $records_per_page";
$result = mysqli_query($con, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>ISMAIK BIBLIO - Courses</title>
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
            <h1 class="text-white display-1">Courses</h1>
            <div class="d-inline-flex text-white mb-5">
                <p class="m-0 text-uppercase"><a class="text-white" href="">Home</a></p>
                <i class="fa fa-angle-double-right pt-1 px-3"></i>
                <p class="m-0 text-uppercase">Courses</p>
            </div>
            <form method="post">
                <div class="mx-auto mb-5" style="width: 100%; max-width: 600px;">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select class="btn btn-outline-light bg-white text-body px-4" name="category">
                                <option value="">Category</option>

                                <?php $sql=mysqli_query($con,"select * from category");
                                $cnt=1;
                                while($row=mysqli_fetch_array($sql))
                                { ?>
                                <option value="<?php echo htmlentities($row['id']);?>">
                                    <?php echo htmlentities($row['nameCat']);?></option>
                                <?php $cnt++;
                            }?>
                            </select>

                        </div>
                        <input type="text" name="search" placeholder="Search..." value="<?php echo $search; ?>"
                            class="form-control border-light" style="padding: 30px 25px;">
                        <div class="input-group-append">
                            <button class="btn btn-secondary px-4 px-lg-5" name="submit" type="submit">Search</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- Header End -->


    <!-- Courses Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row mx-0 justify-content-center">
                <div class="col-lg-8">
                    <div class="section-title text-center position-relative mb-5">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Our Courses</h6>
                        <h1 class="display-4">Checkout New Releases Of Our Courses</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php 
if(mysqli_num_rows($result) == 0) {
    // Display a paragraph if the courses table is null
    echo "<p>No courses available at the moment.</p>";
} else {
    // Iterate through the results if there are rows in the table
    while ($row = mysqli_fetch_assoc($result)) {
?>
                <div class="col-lg-4 col-md-6 pb-4">
                    <a class="courses-list-item position-relative d-block overflow-hidden mb-2"
                        href="detail.php?id=<?php echo $row['id'];?>">
                        <img class="img-fluid" src="img/courses-1.jpg" alt="">
                        <div class="courses-text">
                            <h4 class="text-center text-white px-3"><?php echo $row['courseName'];?></h4>
                            <div class="border-top w-100 mt-3">
                                <div class="d-flex justify-content-between p-4">
                                    <span class="text-white"><i
                                            class="fa fa-user mr-2"></i><?php echo $row['author_name'];?></span>
                                    <span class="text-white"><i class="fa fa-star mr-2"></i><?php echo $row['rate'];?>
                                        <small>(<?php echo $row['courseUnit'];?>)</small></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <?php 
    }
}
?>
                <div class="col-12">
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-lg justify-content-center mb-0">
                            <?php if ($current_page > 1) {?>
                            <li class="page-item">
                                <a class="page-link rounded-0"
                                    href="?page=<?php echo ($current_page - 1) . (empty($search) ? "" : "&search=$search"); ?>"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            <?php }?>
                            <?php for ($page = 1; $page <= $total_pages; $page++) {
                                
                            ?>

                            <li class="page-item <?php if ($_GET['page']==$page)echo "active";?>"><a class="page-link"
                                    href="?page=<?php echo $page . (empty($search) ? "" : "&search=$search"); ?>"><?php echo $page;?></a>
                            </li>
                            <?php }?>
                            <?php if ($current_page < $total_pages) {?>
                            <li class="page-item">
                                <a class="page-link rounded-0"
                                    href="?page=<?php echo ($current_page + 1) . (empty($search) ? "" : "&search=$search"); ?>"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                            <?php }?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- Courses End -->


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