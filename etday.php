<?php 
session_start(); 
if($_SESSION['status'] != "Active") 
{
    header("location:  index.php");
}
?>
	<html>

	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="s2.css" /> 
	</head>

	<body>
		<div class="container">
			<form>
				<div class="imgcontainer"> <span onclick="window.location.href = 'tabs10.php'" class="close" title="Close">&times;</span> </div>
				<div class="container">
					<table class="data-table">
						<caption class="title" style="text-align: center; font-size: 20px; ">Transaction details(debit) of your branch for last 30 days</caption>
						<thead>
							<tr>
								<th>Transaction_id</th>
								<th>Date</th>
								<th>Amount</th>
								<th>Customer id</th>
								<th>From_Accno</th>
								<th>To_Accno</th>
							</tr>
						</thead>
						<tbody>
							<?php
          error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_STRICT);
          include("dbcon.php");
          $date   = date("Y-m-d");
          $empid = $_SESSION['empid'];
          $result = mysqli_query($db, "SELECT * FROM employee WHERE empid = '$empid'") or die('SQL Error: ' . mysqli_error($db));
          $row1 = mysqli_fetch_array($result);
          $ifsc= $row1['ifsc'];
          $ifsc = mysqli_real_escape_string($db, $ifsc);
          $query = "CREATE OR REPLACE view trans as select distinct t.transid,t.transdate,t.amount,t.custid,t.accno,t.to_acc  from account a, employee e, transaction t where e.ifsc=a.ifsc and a.accno=t.accno and e.ifsc='$ifsc'";
          $resultx = mysqli_query($db, $query) or die('SQL 1Error: '. mysqli_error($db));

          if (mysqli_multi_query($db, "SELECT transid ,transdate ,amount ,custid ,accno ,to_acc FROM trans where transdate >= DATE_ADD( '$date',INTERVAL -30 DAY) order by transdate ")  or die('SQL Error: ' . mysqli_error($db))) {
              do {
                  if ($result1 = mysqli_store_result($db)) {
                      while ($row = mysqli_fetch_row($result1)) {
							echo '<tr>
							<td>'.$row[0].'</td>
							<td>'.$row[1].'</td>
                  <td>'.$row[2].'</td>
                  <td>'.$row[3].'</td>
                  <td>'.$row[4].'</td>
                  <td>'.$row[5].'</td>
                  </tr>';
                      }
                      mysqli_free_result($result1);
                  }
              } while (mysqli_next_result($db));
          }
          mysqli_close($db);
          ?>
					</table>
					<br>
					<table class="data-table">
						<caption class="title" style="text-align: center; font-size: 20px; " s>Transaction details(credit) of your branch for last 30 days</caption>
						<thead>
							<tr>
								<th>Transaction_id</th>
								<th>Date</th>
								<th>Amount</th>
								<th>Customer id</th>
								<th>To_Accno</th>
								<th>From_Accno</th>
							</tr>
						</thead>
						<tbody>
							<?php
							error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_STRICT);
                            include("dbcon.php");
                            $date   = date("Y-m-d");
                            $empid = $_SESSION['empid'];
                            $result = mysqli_query($db, "SELECT * FROM employee WHERE empid = '$empid'") or die('SQL Error: ' . mysqli_error($db));
                            $row1 = mysqli_fetch_array($result);
                            $ifsc= $row1['ifsc'];
                            $ifsc = mysqli_real_escape_string($db, $ifsc);
                            $query = "CREATE OR REPLACE view trans as select distinct t.transid,t.transdate,t.amount,t.custid,t.accno,t.to_acc  from account a, employee e, transaction t where e.ifsc=a.ifsc and a.accno=t.to_acc and e.ifsc='$ifsc'";
                            $resultx = mysqli_query($db, $query) or die('SQL 1Error: '. mysqli_error($db));

                            if (mysqli_multi_query($db, "SELECT transid ,transdate ,amount ,custid ,accno ,to_acc FROM trans where transdate >= DATE_ADD( '$date',INTERVAL -30 DAY)  order by transdate ")  or die('SQL Error: ' . mysqli_error($db))) {
                                do {
                                    if ($result1 = mysqli_store_result($db)) {
                                       while ($row = mysqli_fetch_row($result1)) {
                                            echo '<tr>
											<td>'.$row[0].'</td>
											<td>'.$row[1].'</td>
											<td>'.$row[2].'</td>
                                            <td>'.$row[3].'</td>
											<td>'.$row[5].'</td>
											<td>'.$row[4].'</td>
											</tr>';
                                        }
                                        mysqli_free_result($result1);
                                    }
                                } while (mysqli_next_result($db));
                            }
                            mysqli_close($db);
                            ?>
						</tbody>
					</table>
					<br>
					<table class="data-table">
						<caption class="title" style="text-align: center; font-size: 20px; ">Interest added to Accounts of your Branch</caption>
						<thead>
							<tr>
								<th>Transaction_id</th>
								<th>Date</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php
    						error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_STRICT);
    						include("dbcon.php");
							$date   = date("Y-m-d");
        					$empid = $_SESSION['empid'];
							$result = mysqli_query($db, "SELECT * FROM employee WHERE empid = '$empid'") or die('SQL Error: ' . mysqli_error($db));
							$row1 = mysqli_fetch_array($result);
							$ifsc= $row1['ifsc'];
							$ifsc = mysqli_real_escape_string($db, $ifsc);
        					if (mysqli_multi_query($db, "SELECT * from acc_interest inner join account on accid=accno where ifsc='$ifsc' and adate>= DATE_ADD( '$date',INTERVAL -30 DAY)order by adate ")  or die('SQL Error: ' . mysqli_error($db))) {
            					do {
                					/* store first result set */
                					if ($result1 = mysqli_store_result($db)) {
                    					while ($row = mysqli_fetch_row($result1)) {
                        					echo '<tr>
											<td>'.$row[2].'</td>
											<td>'.$row[1].'</td>
											<td>'.$row[3].'</td>
											</tr>';
                    					}
                    					mysqli_free_result($result1);
                					}
            					} while (mysqli_next_result($db));
        					}
        					mysqli_close($db);
    						?>
						</tbody>
					</table>
				</div>
				<br>
				<button type="button" onclick="window.location.href= 'index.php'" class="cancelbtn">Logout</button>
			</form>
		</div>
	</body>