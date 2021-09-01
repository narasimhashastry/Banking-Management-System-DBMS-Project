<?php
session_start();
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
include 'dbcon.php';
$_SESSION['cusid'] = $_POST['custid'];
$custid            = mysqli_real_escape_string($db, $_SESSION['cusid']);
$name              = mysqli_real_escape_string($db, $_POST['name']);
$address           = mysqli_real_escape_string($db, $_POST['address']);
$phone             = mysqli_real_escape_string($db, $_POST['phone']);
$mail              = mysqli_real_escape_string($db, $_POST['mail']);
$bdate             = mysqli_real_escape_string($db, $_POST['bdate']);
$gender            = mysqli_real_escape_string($db, $_POST['gender']);
function random_password($length = 10)
{
    $alphabet    = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890!@#$%^&*()_-=+;:,.?';
    $pass        = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n      = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function random_mpin($length = 4)
{
    $alphabet    = '1234567890';
    $pass        = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 4; $i++) {
        $n      = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
$psw = random_password(8);
$psw = md5($psw);
$psw = mysqli_real_escape_string($db, $psw);
$mpin = random_mpin(4);
$mpin = md5($mpin);
$mpin = mysqli_real_escape_string($db, $mpin);

$balance  = mysqli_real_escape_string($db, $_POST['balance']);
$accno    = mysqli_real_escape_string($db, $_POST['accno']);
$accn     = (string) $accno;
$interest = "4.5";
$interest = mysqli_real_escape_string($db, $interest);
$empid    = $_SESSION['empid'];
$empid    = mysqli_real_escape_string($db, $empid);

$result1 = mysqli_query($db, "SELECT * FROM employee WHERE empid = '$empid'") or die('SQL Error: ' . mysqli_error($db));
$row1 = mysqli_fetch_array($result1);
$ifsc = $row1['ifsc'];
$ifsc = mysqli_real_escape_string($db, $ifsc);

$sqli = "INSERT INTO customer VALUES ('$custid', '$name', '$address','$phone','$mail','$bdate','$psw','$gender')";

$res = mysqli_query($db, $sqli) or die(mysqli_error($db));

if($res){
  ?>
  <script>
    alert("Customer data Inserted");
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