<?php
session_start();
include 'dbcon.php';
$_SESSION['custid'] = $_POST['usname'];

$custid   = $_SESSION['custid'];
$password = $_POST['psw'];
$password = md5($password);

//prevent mysql injection
$custid   = stripcslashes($custid);
$password = stripcslashes($password);

$custid   = mysqli_real_escape_string($db, $custid);
$password = mysqli_real_escape_string($db, $password);


$result = mysqli_query($db, "SELECT * FROM customer WHERE custid = '$custid' and password = '$password'") or die('SQL Error: ' . mysqli_error($db));
$row = mysqli_fetch_array($result);

if (($row['custid'] == $custid) && ($row['password'] == $password)) {
    $result1 = mysqli_query($db, "SELECT accno FROM account WHERE custid = '$custid'") or die('SQL Error: ' . mysqli_error($db));
    $row1              = mysqli_fetch_array($result1);
    $acc               = stripcslashes($row1[0]);
    $acc               = mysqli_real_escape_string($db, $acc);
    $_SESSION['accno'] = $acc;
    $result2 = mysqli_query($db, "SELECT iddeposit FROM deposits WHERE custid = '$custid'") or die('SQL Error: ' . mysqli_error($db));
    $row2              = mysqli_fetch_array($result2);
    $de                = stripcslashes($row2[0]);
    $de                = mysqli_real_escape_string($db, $de);
    $_SESSION['depid'] = $de;
    $_SESSION['status'] = "Active";
    header("location: tabs1.php");
} else {
    $msg = "Your Username or Password is invalid";
	echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
	header("Refresh: 0,url=tabs10.php");
}

mysqli_close($db);
?>