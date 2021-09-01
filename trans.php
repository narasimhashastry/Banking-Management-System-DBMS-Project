<?php
session_start();
include 'dbcon.php';
error_reporting(E_ALL ^ E_WARNING ^E_NOTICE);

$amount = mysqli_real_escape_string($db, $_POST['amount']);
if (isset($_POST['t1accno'])) {
    $taccno = mysqli_real_escape_string($db, $_POST['t1accno']);
    $result1 = mysqli_query($db, "SELECT tifsc FROM beneficiary WHERE taccno = '$taccno'") or die('SQL Error: ' . mysqli_error($db));
    $row1 = mysqli_fetch_array($result1);
    
    $tifsc = mysqli_real_escape_string($db, $row1[0]);
} else if (isset($_POST['taccno'])) {
    $taccno = mysqli_real_escape_string($db, $_POST['taccno']);
    $tifsc  = mysqli_real_escape_string($db, $_POST['tifsc']);
}
$mpin   = mysqli_real_escape_string($db, $_POST['mpin']);
$mpin   = md5($mpin);
$mpin   = mysqli_real_escape_string($db, $mpin);
$custid = $_SESSION['custid'];
$custid = mysqli_real_escape_string($db, $custid);
$accno  = $_SESSION['accno'];
$accno  = mysqli_real_escape_string($db, $accno);
$date   = date("Y/m/d");
$result = mysqli_query($db, "SELECT balance FROM account WHERE accno = '$accno'") or die('SQL Error: ' . mysqli_error($db));
$row  = mysqli_fetch_array($result);
$abal = $row[0];
$result = mysqli_query($db, "SELECT mpin FROM account WHERE accno = '$accno'") or die('SQL Error: ' . mysqli_error($db));
$row   = mysqli_fetch_array($result);
$mpind = $row[0];
$result = mysqli_query($db, "SELECT blocked FROM account WHERE accno = '$accno'") or die('SQL Error: ' . mysqli_error($db));
$row  = mysqli_fetch_array($result);
$blocked = $row[0];
if($blocked == 0)
{
if ($mpin == $mpind) {
    if ($amount > $abal) {
        echo "enter an amount less than your current balance $abal";
    } else {
        $sqli = "UPDATE account set balance= balance+$amount where accno=$taccno";
        if ($stmti = mysqli_prepare($db, $sqli)) {
            mysqli_stmt_bind_param($stmti, "s", $amount);
            if (mysqli_stmt_execute($stmti)) {
                $sql = "INSERT into transaction(transdate,amount,custid,accno,to_acc) VALUES ('$date','$amount','$custid','$accno','$taccno')";
                if ($stmt = mysqli_prepare($db, $sql)) {
                    mysqli_stmt_bind_param($stmt, "sssss", $date, $amount, $custid, $accno, $taccno);
                    if (mysqli_stmt_execute($stmt)) {
                        $balance = $abal - $amount;
                        $sqli = "UPDATE account set balance=$balance where accno=$accno";
                        if ($stmti = mysqli_prepare($db, $sqli)) {
                            mysqli_stmt_bind_param($stmti, "s", $balance);
                            if (mysqli_stmt_execute($stmti)) {
						        $result = mysqli_query($db, "SELECT balance from account where accno='$accno'") or die('SQL Error: ' . mysqli_error($db));
						        $row = mysqli_fetch_array($result);
						        $msg = "Updated balance is ".$row[0];
						        echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
                                header("Refresh: 0,url=tabs1.php");
                            }else {
                                $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
                                echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
                                header("Refresh: 0,url=tabs1.php");
                            } 
                        }else {
                        $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
						echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
						header("Refresh: 0,url=tabs1.php");
                    }
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
        }else {
            $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
            echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
            header("Refresh: 0,url=tabs1.php");
        }} else {
            $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
			echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
			header("Refresh: 0,url=tabs1.php");
        }  
    }
} else {
    $msg = "Incorrect mpin";
    echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
    header("Refresh: 0,url=tabs1.php");
        }
}
else{
    $msg = "Account blocked, please contact branch";
    echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
    header("Refresh: 5,url=tabs1.php");
}