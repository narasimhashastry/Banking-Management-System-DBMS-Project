<?php
session_start();
include 'dbcon.php';
$accID = $_POST['accid'];

$accID = mysqli_real_escape_string($db, $accID);

$result1 = mysqli_query($db, "SELECT accno FROM account WHERE accno = '$accID'") or die('SQL Error: ' . mysqli_error($db));
$row1 = mysqli_fetch_array($result1);
if ($accID != $row1[0]) {
    $msg = "Account does not exist";
    echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
    header("Refresh: 1,url=tabs10.php");
}
else{
if(isset($_POST['block']))
{
    $blocked = 1;
    $sql = "UPDATE account set blocked=$blocked where accno=$accID;";
        if ($stmti = mysqli_prepare($db, $sql)) {
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmti)) {
                $msg = "Account blocked";
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
else
{
    $blocked= 0;
    $sql = "UPDATE account set blocked=$blocked where accno=$accID;";
        if ($stmti = mysqli_prepare($db, $sql)) {
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmti)) {
                $msg = "Account unblocked";
				echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
				header("Refresh: 1,url=tabs10.php");
            } else {
                $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
				echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
				header("Refresh:1,url=tabs10.php");
            }
        } else {
            $msg = "ERROR: Could not execute query: $sql. " . mysqli_error($db);
			echo "<script type=\"text/javascript\">alert(\"$msg\");</script>";
			header("Refresh: 1,url=tabs10.php");
        }
}
}
mysqli_close($db);
?> 