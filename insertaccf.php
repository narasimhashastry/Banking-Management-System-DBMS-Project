<?php
session_start();
include 'dbcon.php';
error_reporting(E_ALL ^ E_WARNING);
$custid = mysqli_real_escape_string($db, $_POST['custid']);
$amount = mysqli_real_escape_string($db, $_POST['amount']);
$period = mysqli_real_escape_string($db, $_POST['period']);
$roi    = $period + 7;

$empid = $_SESSION['empid'];
$empid = mysqli_real_escape_string($db, $empid);
$result1 = mysqli_query($db, "SELECT * FROM employee WHERE empid = '$empid'") or die('SQL Error: ' . mysqli_error($db));
$row1 = mysqli_fetch_array($result1);
$ifsc = $row1['ifsc'];
echo "<script type=\"text/javascript\">alert(\"$ifsc\");</script>";

$ifsc = mysqli_real_escape_string($db, $ifsc);

// Attempt insert query execution
$sql = "INSERT INTO deposits(period,roi,bifsc,custid,amount) VALUES ('$period', '$roi', '$ifsc','$custid','$amount')";

$res = mysqli_query($db, $sql) or die(mysqli_error($db));

if($res){
  ?>
  <script>
    alert("Data Inserted");
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