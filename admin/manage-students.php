<?php
session_start();
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{


    // Define number of records per page
$records_per_page =5;

// Get total number of records
$sql_count = "SELECT COUNT(*) as total FROM students";
$result_count = mysqli_query($con, $sql_count);
$row_count = mysqli_fetch_assoc($result_count);
$total_records = $row_count['total'];

// Calculate total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Handle search
$search = "";
$cat="";
if (isset($_POST['search'])) {
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

$sql = "SELECT * FROM students";
if (!empty($search)) {
    $sql .= " WHERE studentName LIKE '%$search%' OR email LIKE '%$search%'";
}

$sql .= " LIMIT $start, $records_per_page";
$result = mysqli_query($con, $sql);





date_default_timezone_set('Africa/Tunisia');// change according timezone
$currentTime = date( 'd-m-Y h:i:s A', time () );
// Check if a message is set in the session
if($_SESSION['manage_msg']!="") {
    echo '<script>alert("'.$_SESSION['manage_msg'].'")</script>';
    // Unset the session variable to clear the message
    unset($_SESSION['manage_msg']);
}

if(isset($_POST['addstudent'])){
    $studentName=$_POST['studentName'];
    $studentEmail=$_POST['studentEmail'];
    $studentRegno=$_POST['studentRegno'];
    $password=md5('ismaik');

    $pincode = rand(100000,999999);

$ret=mysqli_query($con,"insert into students(StudentRegno,studentName,email,password,pincode) values('$studentRegno','$studentName','$studentEmail','$password','$pincode')");
if($ret){
    $_SESSION['manage_msg']="Student added Successfully !!";
}else{
    $_SESSION['manage_msg']="Something went Wrong !!";

}
header("location:manage-students.php");
}



if(isset($_POST['reset']))
{
$sql=mysqli_query($con,"SELECT password FROM  admin where password='".md5($_POST['cpass'])."' && username='".$_SESSION['alogin']."'");
$num=mysqli_fetch_array($sql);
if($num>0)
{
 $con=mysqli_query($con,"update admin set password='".md5($_POST['newpass'])."', updationDate='$currentTime' where username='".$_SESSION['alogin']."'");
$_SESSION['manage_msg']=  "Password Reset Successfully.";
}else {
$_SESSION['manage_msg']= "Old Password not match ";
}
header("location:manage-students.php");

}




// Code for Deletion
if(isset($_GET['del']))
    {
mysqli_query($con,"delete from students where StudentRegno = '".$_GET['id']."'");
$_SESSION['manage_msg']= "Record deleted successfully !!";
header("location: manage-students.php");
    }

//Code for Password Rest
if(isset($_GET['pass']))
      {
        $password="Test@123";
        $newpass=md5($password);
              mysqli_query($con,"update students set password='$newpass' where StudentRegno = '".$_GET['id']."'");
              echo '<script>alert("Password Reset. New Password is Test@123")</script>';
              $_SESSION['manage_msg']="Password Reset. New Password is Test@123";
               header('Location: manage-students.php');
      } 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Connect Courses - Manage Student</title>
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
<script type="text/javascript">
function valid() {
    if (document.chngpwd.cpass.value == "") {
        alert("Current Password Filed is Empty !!");
        document.chngpwd.cpass.focus();
        return false;
    } else if (document.chngpwd.newpass.value == "") {
        alert("New Password Filed is Empty !!");
        document.chngpwd.newpass.focus();
        return false;
    } else if (document.chngpwd.cnfpass.value == "") {
        alert("Confirm Password Filed is Empty !!");
        document.chngpwd.cnfpass.focus();
        return false;
    } else if (document.chngpwd.newpass.value != document.chngpwd.cnfpass.value) {
        alert("Password and Confirm Password Field do not match  !!");
        document.chngpwd.cnfpass.focus();
        return false;
    }
    return true;
}
</script>

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
                    <div class="row g-2 mb-5">
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInputGrid"
                                    placeholder="Enter student name" required name="studentName">
                                <label for="floatingInputGrid">Student Name</label>
                            </div>
                        </div>
                        <div class="col-md">
                            <div class="form-floating">
                                <input type="email" class="form-control" id="floatingInputGrid"
                                    placeholder="name@example.com" name="studentEmail" required>
                                <label for="floatingInputGrid">Email address</label>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="form-floating">
                                <input type="text" class="form-control" id="floatingInputGrid" name="studentRegno"
                                    placeholder="Enter Student Regno" pattern="[0-9]+" required>
                                <label for="floatingInputGrid">Student Reg no</label>
                            </div>
                        </div>

                        <div class="col-md">
                            <div class="">
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-info w-100 mt-2" name="addstudent">Add
                                        Student</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reg No </th>
                                <th>Student Name </th>
                                <th>Email</th>
                                <th>Reg Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $cnt=1;
                if(mysqli_num_rows($result) == 0) {

                    // Display a paragraph if the courses table is null 
                    echo "<p>No Students available at the moment.</p>";
                } else {
                // Iterate through the results if there are rows in the table
                while ($row = mysqli_fetch_assoc($result)) {
                ?>


                            <tr>
                                <td><?php echo $cnt;?></td>
                                <td><?php echo htmlentities($row['StudentRegno']);?></td>
                                <td><?php echo htmlentities($row['studentName']);?></td>
                                <td><?php echo htmlentities($row['email']);?></td>
                                <td><?php echo htmlentities($row['creationdate']);?></td>
                                <td>
                                    <a href="edit-student.php?id=<?php echo $row['StudentRegno']?>">
                                        <button class="btn btn-primary btn-sm"><i class="fa fa-edit "></i>
                                            Edit</button> </a>
                                    <a href="manage-students.php?id=<?php echo $row['StudentRegno']?>&del=delete"
                                        onClick="return confirm('Are you sure you want to delete?')">
                                        <button class="btn btn-danger btn-sm">Delete</button>
                                    </a>
                                    <a href="manage-students.php?id=<?php echo $row['StudentRegno']?>&pass=update"
                                        onClick="return confirm('Are you sure you want to reset password?')">
                                        <button type="submit" name="reset" id="submit" class="btn btn-info btn-sm">Reset
                                            Password</button>
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