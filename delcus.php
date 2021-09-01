 <?php
include 'dbcon.php';
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_STRICT);
$custid = mysqli_real_escape_string($db, $_POST['custid']);
$sql    = "DELETE FROM customer WHERE custid='$custid'";
$res = mysqli_query($db, $sql) or die(mysqli_error($db));

if($res){
  ?>
  <script>
	alert("Customer Data deleted");
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