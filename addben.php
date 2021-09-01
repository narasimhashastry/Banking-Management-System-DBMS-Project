 <?php
session_start();
include 'dbcon.php';
error_reporting(E_ALL ^ E_WARNING);

$custid = mysqli_real_escape_string($db, $_SESSION['custid']);
$taccno = mysqli_real_escape_string($db, $_POST['taccno']);
$ifsc   = mysqli_real_escape_string($db, $_POST['tifsc']);
$bname  = mysqli_real_escape_string($db, $_POST['bname']);

$result1 = mysqli_query($db, "SELECT ifsc FROM account WHERE accno = '$taccno'") or die('SQL Error: ' . mysqli_error($db));
$row1 = mysqli_fetch_array($result1);

$res = mysqli_query($db, $row1) or die(mysqli_error($db));

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