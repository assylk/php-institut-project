<?php
session_start();
error_reporting(0);
include("includes/config.php");
    // Check if a message is set in the session
if(isset($_SESSION['errmsg'])) {
    echo '<script>alert("'.$_SESSION['errmsg'].'")</script>';
    // Unset the session variable to clear the message
    unset($_SESSION['errmsg']);
}
$query=mysqli_query($con,"SELECT * FROM students");
$countstudents=mysqli_num_rows($query);

$query1=mysqli_query($con,"SELECT * FROM course");
$countcourses=mysqli_num_rows($query1);

$query2=mysqli_query($con,"SELECT * FROM session");
$countsession=mysqli_num_rows($query2);

$query3=mysqli_query($con,"SELECT * FROM courseenrolls");
$countcoursenrolls=mysqli_num_rows($query3);
if(isset($_POST['submit']))
{
    $regno=$_POST['regno'];
    $password=md5($_POST['password']);
    
$query=mysqli_query($con,"SELECT * FROM students WHERE StudentRegno='$regno' and password='$password' ORDER BY RAND() LIMIT 8");
$num=mysqli_fetch_array($query);

if($num>0)
{
$_SESSION['login']=$_POST['regno'];
$_SESSION['id']=$num['studentRegno'];
$_SESSION['sname']=$num['studentName'];
$pincode = rand(100000,999999);

$uip=$_SERVER['REMOTE_ADDR'];
$status=1;
$log=mysqli_query($con,"insert into userlog(studentRegno,userip,status) values('".$_SESSION['login']."','$uip','$status')");
header("location:index.php");
$_SESSION['errmsg']="Successfully Loged In !";
}else{
$_SESSION['errmsg']="Invalid Reg no or Password";
header("location:index.php#login");
}
}




//Code for Insertion
if(isset($_POST['submitMessage']))
{
$name=$_POST['name'];
$email=$_POST['email'];
$subject=$_POST['subject'];
$msg=$_POST['msg'];
$ret=mysqli_query($con,"insert into message(name,email,subject,msg) values('$name','$email','$subject','$msg')");
if($ret)
{
    $_SESSION['errmsg']= "Your Message has been sent Successfully.";
    
}else {
    $_SESSION['errmsg']= "Failed to send your message! Please try again later."; 
}
header("location:index.php");
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Connect Courses - Home</title>
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
<style>
html {
    scroll-behavior: smooth;

}
</style>
<body>
    <!-- Topbar Start -->
    <?php include('includes/topbar.php'); ?>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <a href="index.html" class="navbar-brand ml-lg-3">
                <img src="img/logo2.png" alt="Logo" style="width: 250px;">
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="index.php" class="nav-item nav-link active">Home</a>
                    <a href="courses.php" class="nav-item nav-link">Courses</a>
                    <?php if($_SESSION['login']!=""){ ?>

                    <a href="add-course.php" class="nav-item nav-link">Add Course</a>
                    <a href="profile.php" class="nav-item nav-link">Profile</a>
                    <a href="logout.php" class="nav-item nav-link" style="color:red">Logout</a>
                    <?php }?>

                </div>
                <?php if($_SESSION['login']==""){ ?>
                <a href="index.php#login" class="btn btn-primary py-2 px-4 d-none d-lg-block">Join Us</a>
                <?php }else{ ?>
                <a href="logout.php" class="btn btn-primary py-2 px-4 d-none d-lg-block">Logout</a>
                <?php }?>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->


    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid position-relative overlay-bottom" style="margin-bottom: 90px;">
        <div class="container text-center my-5 py-5">
            <h1 class="text-white mt-4 mb-4">Learn From Home</h1>
            <h1 class="text-white display-1 mb-5">Connect Courses</h1>

        </div>
    </div>
    <!-- Header End -->


    <!-- About Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100" src="img/about.jpg" style="object-fit: cover;">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">About Us</h6>
                        <h1 class="display-4">First Choice For Online Education Anywhere</h1>
                    </div>
                    <p>Welcome to Connect Courses, your premier destination for online education anywhere! At Ismaik, we
                        pride
                        ourselves on offering top-quality courses that cater to the diverse learning needs of students
                        worldwide. Whether you're looking to enhance your skills, advance your career, or explore new
                        interests, our extensive range of courses has something for everyone. With our user-friendly
                        platform, you can access world-class education from the comfort of your own home or on the go.
                        Our team of experienced instructors ensures that you receive engaging and informative lessons
                        that empower you to succeed. Join Connect Courses today and embark on your journey towards a
                        brighter
                        future!"</p>
                    <div class="row pt-3 mx-0">
                        <div class="col-3 px-0">
                            <div class="bg-success text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up"><?php echo $countsession;?></h1>
                                <h6 class="text-uppercase text-white">Available<span class="d-block">Sessions</span>
                                </h6>
                            </div>
                        </div>
                        <div class="col-3 px-0">
                            <div class="bg-primary text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up"><?php echo $countcourses;?></h1>
                                <h6 class="text-uppercase text-white">Total<span class="d-block">Courses</span></h6>
                            </div>
                        </div>
                        <div class="col-3 px-0">
                            <div class="bg-secondary text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up"><?php echo $countcoursenrolls;?></h1>
                                <h6 class="text-uppercase text-white">Rolled<span class="d-block">Courses</span>
                                </h6>
                            </div>
                        </div>
                        <div class="col-3 px-0">
                            <div class="bg-warning text-center p-4">
                                <h1 class="text-white" data-toggle="counter-up"><?php echo $countstudents;?></h1>
                                <h6 class="text-uppercase text-white">Happy<span class="d-block">Students</span></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- About End -->


    <!-- Feature Start -->
    <div class="container-fluid bg-image" style="margin: 90px 0;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 my-5 pt-5 pb-lg-5">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Why Choose Us?
                        </h6>
                        <h1 class="display-4">Why You Should Start Learning with Us?</h1>
                    </div>
                    <p class="mb-4 pb-2">"Discover the advantages of learning with Connect Courses! With our diverse
                        courses,
                        expert instructors, and flexible scheduling, we offer a superior learning experience tailored to
                        your needs. Join us today to unlock your full potential!"</p>
                    <div class="d-flex mb-3">
                        <div class="btn-icon bg-primary mr-4">
                            <i class="fa fa-2x fa-graduation-cap text-white"></i>
                        </div>
                        <div class="mt-n1">
                            <h4>Skilled Instructors</h4>
                            <p>At Connect Courses, our skilled instructors ensure top-quality learning. With expertise
                                in their
                                fields, they provide engaging education for your success. Join us today and learn from
                                the best!</p>
                        </div>
                    </div>
                    <div class="d-flex mb-3">
                        <div class="btn-icon bg-secondary mr-4">
                            <i class="fa fa-2x fa-certificate text-white"></i>
                        </div>
                        <div class="mt-n1">
                            <h4>International Certificate</h4>
                            <p>Get recognized globally with Connect Course's international certificates. Boost your
                                career or
                                academic credentials today!</p>
                        </div>
                    </div>
                    <div class="d-flex">
                        <div class="btn-icon bg-warning mr-4">
                            <i class="fa fa-2x fa-book-reader text-white"></i>
                        </div>
                        <div class="mt-n1">
                            <h4>Online Classes</h4>
                            <p class="m-0">Join Connect Courses for flexible online learning. Explore diverse courses,
                                expert
                                instructors, and achieve your goals from anywhere.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" style="min-height: 500px;">
                    <div class="position-relative h-100">
                        <img class="position-absolute w-100 h-100" src="img/feature.jpg" style="object-fit: cover;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature Start -->


    <!-- Courses Start -->

    <div class="container-fluid px-0 py-5">
        <div class="row mx-0 justify-content-center pt-5">
            <div class="col-lg-6">
                <div class="section-title text-center position-relative mb-4">
                    <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Our Courses</h6>
                    <h1 class="display-4">Checkout New Releases Of Our Courses</h1>
                </div>
            </div>
        </div>
        <div class="owl-carousel courses-carousel">

            <?php
$sql = mysqli_query($con,"SELECT course.*, students.studentName AS author_name FROM course INNER JOIN students ON course.author = students.StudentRegno ORDER BY RAND() LIMIT 8");
if(mysqli_num_rows($sql) == 0) {
    ?>
            <p>No Courses Available Now</p>
            <?php
            }else{

$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>
            <div class="courses-item position-relative">
                <img class="img-fluid" style="height:400px;object-fit:cover"
                    src="<?php echo htmlentities($row['portrait']); ?>" alt="">
                <div class="courses-text">
                    <h4 class="text-center text-white px-3"><?php echo htmlentities($row['courseName']);?></h4>
                    <div class="border-top w-100 mt-3">
                        <div class="d-flex justify-content-between p-4">
                            <span class="text-white"><i
                                    class="fa fa-user mr-2"></i><?php echo htmlentities($row['author_name']);?></span>
                            <span class="text-white"><i class="fa fa-star mr-2"></i>4.5
                                <small>(<?php echo htmlentities($row['courseUnit']); ?>)</small></span>
                        </div>
                    </div>
                    <div class="w-100 bg-white text-center p-4">
                        <a class="btn btn-primary" href="detail.php?id=<?php echo htmlentities($row['id']); ?>">Course
                            Detail</a>
                    </div>
                </div>
            </div>
            <?php $cnt++;}}?>

        </div>

        <?php if($_SESSION['login']==""){ ?>
        <div class="row justify-content-center bg-image mx-0 mb-5">
            <div class="col-lg-6 py-5" id="login">
                <div class="bg-white p-5 my-5">
                    <h1 class="text-center mb-4">50% Off For New Students</h1>
                    <form name="admin" method="post">
                        <div class="form-row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="text" name="regno" class="form-control bg-light border-0"
                                        placeholder="Enter Reg no" style="padding: 30px 20px;">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control bg-light border-0"
                                        placeholder="Your Password" style="padding: 30px 20px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-row">

                            <div class="col-md-12 ">
                                <button class="btn btn-primary btn-block" type="submit" name="submit"
                                    style="height: 60px;">Sign In
                                    Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php } ?>
    </div>
    <!-- Courses End -->


    <!-- Team Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="section-title text-center position-relative mb-5">
                <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Instructors</h6>
                <h1 class="display-4">Meet Our Instructors</h1>
            </div>
            <div class="owl-carousel team-carousel position-relative" style="padding: 0 30px;">
                <div class="team-item">
                    <img class="img-fluid w-100" src="img/team-1.jpg" alt="">
                    <div class="bg-light text-center p-4">
                        <h5 class="mb-3">Instructor Name</h5>
                        <p class="mb-2">Web Design & Development</p>
                        <div class="d-flex justify-content-center">
                            <a class="mx-1 p-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <img class="img-fluid w-100" src="img/team-2.jpg" alt="">
                    <div class="bg-light text-center p-4">
                        <h5 class="mb-3">Instructor Name</h5>
                        <p class="mb-2">Web Design & Development</p>
                        <div class="d-flex justify-content-center">
                            <a class="mx-1 p-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <img class="img-fluid w-100" src="img/team-3.jpg" alt="">
                    <div class="bg-light text-center p-4">
                        <h5 class="mb-3">Instructor Name</h5>
                        <p class="mb-2">Web Design & Development</p>
                        <div class="d-flex justify-content-center">
                            <a class="mx-1 p-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="team-item">
                    <img class="img-fluid w-100" src="img/team-4.jpg" alt="">
                    <div class="bg-light text-center p-4">
                        <h5 class="mb-3">Instructor Name</h5>
                        <p class="mb-2">Web Design & Development</p>
                        <div class="d-flex justify-content-center">
                            <a class="mx-1 p-1" href="#"><i class="fab fa-twitter"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-facebook-f"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-instagram"></i></a>
                            <a class="mx-1 p-1" href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Team End -->


    <!-- Testimonial Start -->
    <div class="container-fluid bg-image py-5" style="margin: 90px 0;">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Testimonial
                        </h6>
                        <h1 class="display-4">What Say Our Students</h1>
                    </div>
                    <p class="m-0">Discover what our students have to say about Connect Courses! Hear firsthand
                        experiences
                        and
                        testimonials from individuals who have benefited from our courses. Join our community and
                        share
                        your success story today!</p>
                </div>
                <div class="col-lg-7">
                    <div class="owl-carousel testimonial-carousel">
                        <?php
$sql=mysqli_query($con,"select * from message ORDER BY RAND() LIMIT 6");
$cnt=1;
while($row=mysqli_fetch_array($sql))
{
?>
                        <div class="bg-white p-5">
                            <i class="fa fa-3x fa-quote-left text-primary mb-4"></i>
                            <p><?php echo htmlentities($row['msg']);?></p>
                            <div class="d-flex flex-shrink-0 align-items-center mt-4">
                                <img class="img-fluid mr-4" src="img/testimonial-2.jpg" alt="">
                                <div>
                                    <h5><?php echo htmlentities($row['name']);?></h5>
                                    <span><?php echo htmlentities($row['subject']);?></span>
                                </div>
                            </div>
                        </div>
                        <?php }?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial Start -->


    <!-- Contact Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="bg-light d-flex flex-column justify-content-center px-5" style="height: 450px;">
                        <div class="d-flex align-items-center mb-5">
                            <div class="btn-icon bg-primary mr-4">
                                <i class="fa fa-2x fa-map-marker-alt text-white"></i>
                            </div>
                            <div class="mt-n1">
                                <h4>Our Location</h4>
                                <p class="m-0">Kairouan, Rue ibn Jazzar</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-5">
                            <div class="btn-icon bg-secondary mr-4">
                                <i class="fa fa-2x fa-phone-alt text-white"></i>
                            </div>
                            <div class="mt-n1">
                                <h4>Call Us</h4>
                                <p class="m-0">+216 12 345 678</p>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="btn-icon bg-warning mr-4">
                                <i class="fa fa-2x fa-envelope text-white"></i>
                            </div>
                            <div class="mt-n1">
                                <h4>Email Us</h4>
                                <p class="m-0">connect-courses@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="section-title position-relative mb-4">
                        <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">Give Your
                            Oppinion</h6>
                        <h1 class="display-4">Send Us A Message</h1>
                    </div>
                    <div class="contact-form">
                        <form method="post">
                            <div class="row">
                                <div class="col-6 form-group">
                                    <input type="text"
                                        class="form-control border-top-0 border-right-0 border-left-0 p-0"
                                        placeholder="Your Name" name="name" value="<?php echo $_SESSION['sname']; ?>"
                                        required="required">
                                </div>
                                <div class="col-6 form-group">
                                    <input type="email"
                                        class="form-control border-top-0 border-right-0 border-left-0 p-0"
                                        placeholder="Your Email" name="email" required="required">
                                </div>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control border-top-0 border-right-0 border-left-0 p-0"
                                    placeholder="Subject" name="subject" required="required">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control border-top-0 border-right-0 border-left-0 p-0" rows="5"
                                    placeholder="Message" name="msg" required="required"></textarea>
                            </div>
                            <div>
                                <button class="btn btn-primary py-3 px-5" type="submit" name="submitMessage">Send
                                    Message</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->


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