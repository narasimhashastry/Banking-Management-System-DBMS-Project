<?php
session_start();
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
include 'dbcon.php';
$loanid            = mysqli_real_escape_string($db, $_POST['loanid']);
$ltype              = mysqli_real_escape_string($db, $_POST['ltype']);
$amount           = mysqli_real_escape_string($db, $_POST['amount']);
$roi             = mysqli_real_escape_string($db, $_POST['roi']);
$balance             = mysqli_real_escape_string($db, $_POST['balance']);
$custid           = mysqli_real_escape_string($db, $_POST['custid']);
$empid    = $_SESSION['empid'];
//$empid    = mysqli_real_escape_string($db, $empid);
//echo "<script type=\"text/javascript\">alert(\"$ltype\");</script>";
$result1 = mysqli_query($db, "SELECT * FROM employee WHERE empid = '$empid'") or die('SQL Error: ' . mysqli_error($db));
$row1 = mysqli_fetch_array($result1);
$ifsc = $row1['ifsc'];
//$ifsc = mysqli_real_escape_string($db, $ifsc);
$result1 = mysqli_query($db, "SELECT idloan FROM loan WHERE idloan='$loanid'") or die('SQL Error: ' . mysqli_error($db));
$row1 = mysqli_fetch_array($result1);
$rloanid = $row1[0];
$result1 = mysqli_query($db, "SELECT custid FROM customer WHERE custid='$custid'") or die('SQL Error: ' . mysqli_error($db));
$row1 = mysqli_fetch_array($result1);

if ($custid != $row1[0]) {
    $msg = "Account(Customer id) does not exist";
    echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
    header("Refresh: 1,url=tabs10.php");
}
else{
if(isset($_POST['insert'])){
if($rloanid != $loanid){
$sqli = "INSERT INTO loan(idloan,type,amount,interest,balance,custid) VALUES ('$loanid', '$ltype', '$amount','$roi','$balance','$custid')";
if ($stmti = mysqli_prepare($db, $sqli)) {
        //mysqli_stmt_bind_param($stmti, "isdddi", $loanid, $ltype, $amount,$roi, $balance,$custid);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmti)) {
                $msg = "Loan record inserted";
				echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
				header("Refresh: 1,url=tabs10.php");
            } else {
                $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
				echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
				header("Refresh: 1,url=tabs10.php");
            }
        } else {
            $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
			echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
			header("Refresh: 1,url=tabs10.php");
        }
    }
    else{
        $msg = "Loan record exists, please choose update option instead of insert";
		echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
		header("Refresh: 1,url=tabs10.php");
    }
} else if(isset($_POST['update'])) {
    if($rloanid == $loanid){
        $sqli = "UPDATE loan SET interest=$roi, balance=$balance WHERE idloan=$rloanid;";
        if ($stmti = mysqli_prepare($db, $sqli)) {
                //mysqli_stmt_bind_param($stmti, "isdddi", $loanid, $ltype, $amount,$roi, $balance,$custid);
                    // Attempt to execute the prepared statement
                    if (mysqli_stmt_execute($stmti)) {
                        $msg = "Loan record updated";
                        echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
                        header("Refresh: 1,url=tabs10.php");
                    } else {
                        $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
                        echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
                        header("Refresh: 1,url=tabs10.php");
                    }
                } else {
                    $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
                    echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
                    header("Refresh: 1,url=tabs10.php");
                }
            }
            else{
                $msg = "Loan record does not exist, cannot update";
                echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
                header("Refresh: 1,url=tabs10.php");
            }
}
}
mysqli_stmt_close($stmti);
mysqli_stmt_close($stmt);
mysqli_close($db);
?>