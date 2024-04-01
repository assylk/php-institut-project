<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
date_default_timezone_set('Africa/Tunis');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );
// Define number of records per page
$records_per_page = 5;

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

$sql = "SELECT * FROM course";
if (empty($cat)) {
    $sql .= " WHERE courseName LIKE '%$search%' OR author LIKE '%$search%' OR courseCode LIKE '%$search%'";
}
if (!empty($search)&&!empty($cat)) {
    $sql .= " WHERE (courseName LIKE '%$search%' OR author LIKE '%$search%' OR courseCode LIKE '%$search%') and category='$cat'";
}
$sql .= " LIMIT $start, $records_per_page";
$result = mysqli_query($con, $sql);
// Check if a message is set in the session
if(isset($_SESSION['message'])) {
    echo '<script>alert("'.$_SESSION['message'].'")</script>';
    // Unset the session variable to clear the message
    unset($_SESSION['message']);
}

// Code for Deletion
if(isset($_GET['del']))
{
mysqli_query($con,"delete from course where id = '".$_GET['id']."'");
$_SESSION['message']="Course deleted!";
header("location:manage-courses.php");
      }


if(isset($_POST['addCourse'])){
    $courseCode=$_POST['courseCode'];
    $courseName=$_POST['courseName'];
    $coursePrice= $_POST['coursePrice'];
    
    // Insert user details into the database
    

    $sql=mysqli_query($con,"Insert into course(courseCode,courseName,price) values('$courseCode','$courseName','$coursePrice')");
    if ($sql) {
        $_SESSION['message']= "New course added successfully";
    }else{
        $_SESSION['message']= "Error adding new course, please try again.";
    }
    header('Location:manage-courses.php');
}





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
    <?php include("includes/navbar.php"); ?>

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


    <!-- About Start -->
    <div class="container-fluid">
        <div class="container">

            <div class="row">
                <form method="post">
                    <div class="row g-3 mb-5">
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input type="text" name="courseCode" class="form-control" id="floatingInput" required
                                    placeholder="Enter Course Code">
                                <label for="floatingInput">Course Code</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input type="text" name="courseName" class="form-control" id="floatingInput" required
                                    placeholder="Enter Course Name">
                                <label for="floatingInput">Course Name</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating mb-3">
                                <input type="text" name="coursePrice" class="form-control" id="floatingInput" required
                                    placeholder="Enter Course Price" pattern="[0-9]+">
                                <label for="floatingInput">Price</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" name="addCourse" value="Add Course"
                                class="btn btn-info btn-group-lg w-100 mt-2">
                        </div>

                    </div>
                </form>

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
                            <div class="table-responsive">
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Course Code</th>
                                            <th>Course Name </th>
                                            <th>Course Unit</th>
                                            <th>User Rate</th>
                                            <th>Creation Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $cnt=1;
if(mysqli_num_rows($result) == 0) {
    // Display a paragraph if the courses table is null
    echo "<p>No courses available at the moment.</p>";
} else {
    // Iterate through the results if there are rows in the table
    while ($row = mysqli_fetch_assoc($result)) {
?>


                                        <tr>
                                            <td><?php echo $cnt;?></td>
                                            <td><?php echo htmlentities($row['courseCode']);?></td>
                                            <td><?php echo htmlentities($row['courseName']);?></td>
                                            <td><?php echo htmlentities($row['courseUnit']);?></td>
                                            <td><?php echo htmlentities($row['rate']);?></td>
                                            <td><?php echo htmlentities($row['creationDate']);?></td>
                                            <td>
                                                <a href="edit-course.php?id=<?php echo $row['coursePin']?>">
                                                    <button class="btn btn-primary btn-sm"><i class="fa fa-edit "></i>
                                                        Edit</button> </a>
                                                <a href="manage-courses.php?id=<?php echo $row['id']?>&del=delete"
                                                    onClick="return confirm('Are you sure you want to delete?')">
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php 
$cnt++;
}} ?>


                                    </tbody>
                                </table>
                            </div>
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

                                        <li class="page-item <?php if ($_GET['page']==$page)echo "active";?>"><a
                                                class="page-link"
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