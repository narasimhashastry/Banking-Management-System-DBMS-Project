 <?php
session_start();
include 'dbcon.php';
error_reporting(E_ALL ^ E_WARNING ^E_NOTICE);
$custid    = mysqli_real_escape_string($db, $_POST['uname']);
$bdate     = mysqli_real_escape_string($db, $_POST['bdate']);
$password  = mysqli_real_escape_string($db, $_POST['psw']);
$password1 = mysqli_real_escape_string($db, $_POST['psw1']);

$result = mysqli_query($db, "SELECT bdate FROM customer WHERE custid=$custid") or die('SQL Error: ' . mysqli_error($db));
$row = mysqli_fetch_array($result);
$dba = $row[0];

if ($dba == $bdate) {
    if ($password == $password1) {
		$password  = md5($password);
		$password  = mysqli_real_escape_string($db, $password);
        $sql = "UPDATE customer set password='$password' where custid=$custid;";
        
        if ($stmti = mysqli_prepare($db, $sql)) {
            mysqli_stmt_bind_param($stmti, "si", $password, $custid);
            
            if (mysqli_stmt_execute($stmti)) {
                $msg = "password reset successful";
				echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
				header("Refresh: 0,url=index.php");
            } else {
                $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
				echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
				header("Refresh: 0,url=index.php");
            }
        } else {
            $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
			echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
			header("Refresh: 0,url=index.php");
        }
    } else {
        $msg = "Passwords don't match";
        echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
        header("Refresh: 0,url=index.php");
    }
} else {
    $msg = "Birth date doesn't match with records or Username entered is wrong";
	echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
    header("Refresh: 0,url=index.php");
}

mysqli_close($db);
?> 