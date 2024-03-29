<?php   
session_start();
include('../includes/config.php');
error_reporting(0);
if(isset($_POST['submitprivate'])) {
    // Retrieve submitted values
    $studentname = $_POST['studentname'];
    $cgpa = $_POST['cgpa'];
    $email = $_POST['email'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];

    // Retrieve existing values from the database
    $existingDataQuery = mysqli_query($con, "SELECT * FROM students WHERE StudentRegno='".$_SESSION['login']."'");
    $existingData = mysqli_fetch_assoc($existingDataQuery);

    // Check if submitted values are different from existing values and update only those that have changed
    $updateQuery = "UPDATE students SET ";
    $updates = [];

    if ($studentname != $existingData['studentName']) {
        $updates[] = "studentName='$studentname'";
    }
    if ($cgpa != $existingData['cgpa']) {
        $updates[] = "cgpa='$cgpa'";
    }
    if ($email != $existingData['email']) {
        $updates[] = "email='$email'";
    }
    if ($city != $existingData['city']) {
        $updates[] = "city='$city'";
    }
    if ($state != $existingData['state']) {
        $updates[] = "state='$state'";
    }
    if ($zip != $existingData['zip']) {
        $updates[] = "zip='$zip'";
    }

    // If any updates are required, execute the update query
    if (!empty($updates)) {
        $updateQuery .= implode(',', $updates);
        $updateQuery .= " WHERE StudentRegno='".$_SESSION['login']."'";

        $ret = mysqli_query($con, $updateQuery);
        if($ret) {
            $_SESSION['message'] = "Student Record updated Successfully !!";
        } else {

            $_SESSION['message'] = "Something went wrong. Please try again!";
        }
    } else {
                $_SESSION['message'] = "No changes detected.";

    }
}



 // Redirect the user back to the form page
    header("Location: ../profile.php");
    exit(); // Make sure to exit after redirection

?>