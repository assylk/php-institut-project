<?php



session_start();
include('../includes/config.php');
error_reporting(0);
if(isset($_POST['submit'])) {
    // Retrieve submitted values
    $courseName = $_POST['courseName'];
    $courseCode = $_POST['courseCode'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $coursePin = $_POST['coursePin'];

    // Retrieve existing values from the database
    $existingDataQuery = mysqli_query($con, "SELECT * FROM course WHERE id='$coursePin'");
    $existingData = mysqli_fetch_assoc($existingDataQuery);

    // Check if submitted values are different from existing values and update only those that have changed
    $updateQuery = "UPDATE course SET ";
    $updates = [];
    echo "<script>alert('".$existingData['courseName']."')</script>";
    if ($courseName != $existingData['courseName']) {
        $updates[] = "courseName='$courseName'";
    }
    if ($courseCode != $existingData['courseCode']) {
        $updates[] = "courseCode='$courseCode'";
    }
    if ($price != $existingData['price']) {
        $updates[] = "price='$price'";
    }
    if ($category != $existingData['category']) {
        $updates[] = "category='$category'";
    }
   

    // If any updates are required, execute the update query
    if (!empty($updates)) {
        $updateQuery .= implode(',', $updates);
        $updateQuery .= " WHERE coursePin='$coursePin'";

        $ret = mysqli_query($con, $updateQuery);
        if($ret) {
            $_SESSION['message'] = "Course Record updated Successfully !!";
        } else {

            $_SESSION['message'] = "Something went wrong. Please try again!";
        }
    } else {
                $_SESSION['message'] = "No changes detected.";

    }
}



 // Redirect the user back to the form page
    header("Location: ../edit-course.php?id=$coursePin");
    exit(); // Make sure to exit after redirection



?>