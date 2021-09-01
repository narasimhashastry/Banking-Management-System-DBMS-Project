<?php
session_start();
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
include 'dbcon.php';

$empidi            = mysqli_real_escape_string($db, $_POST['empidi']);
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

$psw = random_password(8);
$psw = md5($psw);
$psw = mysqli_real_escape_string($db, $psw);

$role  = mysqli_real_escape_string($db, $_POST['role']);
$salary   = mysqli_real_escape_string($db, $_POST['salary']);

$empid    = $_SESSION['empid'];
$empid    = mysqli_real_escape_string($db, $empid);

$result1 = mysqli_query($db, "SELECT * FROM employee WHERE empid = '$empid'") or die('SQL Error: ' . mysqli_error($db));
$row1 = mysqli_fetch_array($result1);
$ifsc = $row1['ifsc'];
$ifsc = mysqli_real_escape_string($db, $ifsc);
$sqli = "INSERT INTO employee VALUES ('$empidi', '$name', '$address','$phone','$mail','$psw','$bdate','$salary','$ifsc','$gender','$role')";

  $res = mysqli_query($db, $sqli) or die(mysqli_error($db));

  if($res){
    ?>
    <script>
      alert("Employee Data Inserted");
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