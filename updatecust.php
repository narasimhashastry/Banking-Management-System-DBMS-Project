<?php
session_start();
include 'dbcon.php';
error_reporting(E_ALL ^ E_WARNING);

$custid  = mysqli_real_escape_string($db, $_SESSION['custid']);
$name    = mysqli_real_escape_string($db, $_POST['name']);
$address = mysqli_real_escape_string($db, $_POST['address']);
$phone   = mysqli_real_escape_string($db, $_POST['phone']);
$mail  = mysqli_real_escape_string($db, $_POST['mail']);
$bdate = mysqli_real_escape_string($db, $_POST['bdate']);
$gender = mysqli_real_escape_string($db, $_POST['gender']);
// Attempt insert query execution
$sqli  = "UPDATE customer set name='$name', address='$address', phone=$phone, email='$mail', bdate='$bdate', gender='$gender' where custid='$custid'";
if ($stmti = mysqli_prepare($db, $sqli)) {
    mysqli_stmt_bind_param($stmti, "ississs", $custid, $name, $address, $phone, $mail, $bdate, $gender);
    
    // Attempt to execute the prepared statement
    if (mysqli_stmt_execute($stmti)) {
        $msg = "Account information updated";
        echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
		header("Refresh: 0,url=tabs1.php");
    } else {
        $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
		echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
		header("Refresh: 0,url=tabs1.php");
    }
} else {
    $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
	echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
	header("Refresh: 0,url=tabs1.php");
}
// Close statement
mysqli_stmt_close($stmti);
mysqli_close($db);
?>