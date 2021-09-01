<?php
session_start();
include 'dbcon.php';
error_reporting(E_ALL ^ E_WARNING);
$empid   = mysqli_real_escape_string($db, $_SESSION['empid']);
$name    = mysqli_real_escape_string($db, $_POST['name']);
$address = mysqli_real_escape_string($db, $_POST['address']);
$phone   = mysqli_real_escape_string($db, $_POST['phone']);
$mail    = mysqli_real_escape_string($db, $_POST['mail']);
$bdate   = mysqli_real_escape_string($db, $_POST['bdate']);
$gender  = mysqli_real_escape_string($db, $_POST['gender']);
// Attempt insert query execution
$sqli    = "UPDATE employee set name='$name', address='$address', phone=$phone, email='$mail', bdate='$bdate', gender='$gender' where empid='$empid'";
$res = mysqli_query($db, $sqli) or die(mysqli_error($db));

if($res){
  ?>
  <script>
    alert("Employee Data updated");
    header("Refresh: 0,url=tabs10.php");
  </script>
  <?php
}else{
  ?>
  <script>
    alert("Data Not Inserted ");
    header("Refresh: 0,url=tabs10.php");
  </script>
  <?php
}
mysqli_close($db);
?>