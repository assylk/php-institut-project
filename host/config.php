<?php
define('DB_SERVER','sql212.infinityfree.com');
define('DB_USER','if0_36211645');
define('DB_PASS' ,'36oZEh0TYLXV0');
define('DB_NAME', 'if0_36211645_onlinecourses');
$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
 echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>