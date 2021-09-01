<?php session_start(); ?>
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
						<caption class="title" style="text-align: center; font-size: 20px; ">Loans(Active) in your branch</caption>
						<thead>
							<tr>
								<th>Loan_id</th>
								<th>Type</th>
								<th>Amount</th>
                                <th>Interest rate</th>
								<th>Balance</th>
								<th>Customer id</th>
							</tr>
						</thead>
						<tbody>
							<?php
          error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_STRICT);
          include("dbcon.php");
          $empid = $_SESSION['empid'];
          $result = mysqli_query($db, "SELECT * FROM employee WHERE empid = '$empid'") or die('SQL Error: ' . mysqli_error($db));
          $row1 = mysqli_fetch_array($result);
          $ifsc= $row1['ifsc'];
          $ifsc = mysqli_real_escape_string($db, $ifsc);
          $query = "CREATE OR REPLACE view loanview as select distinct l.idloan, l.type, l.amount, l.interest, l.balance, l.custid  from account a, employee e, loan l where e.ifsc=a.ifsc and a.custid=l.custid and e.ifsc='$ifsc' and l.balance!=0";
          $resultx = mysqli_query($db, $query) or die('SQL 1Error: '. mysqli_error($db));

          if (mysqli_multi_query($db, "SELECT idloan, type, amount, interest, balance, custid FROM loanview  order by idloan ")  or die('SQL Error: ' . mysqli_error($db))) {
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
						<caption class="title" style="text-align: center; font-size: 20px; " s>Loans(Closed) in your branch</caption>
						<thead>
							<tr>
                                <th>Loan_id</th>
								<th>Type</th>
								<th>Amount</th>
                                <th>Interest rate</th>
								<th>Balance</th>
								<th>Customer id</th>
							</tr>
						</thead>
						<tbody>
							<?php
            error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_STRICT);
            include("dbcon.php");
            $empid = $_SESSION['empid'];
            $result = mysqli_query($db, "SELECT * FROM employee WHERE empid = '$empid'") or die('SQL Error: ' . mysqli_error($db));
            $row1 = mysqli_fetch_array($result);
            $ifsc= $row1['ifsc'];
            $ifsc = mysqli_real_escape_string($db, $ifsc);
            $query = "CREATE OR REPLACE view loanview as select distinct l.idloan, l.type, l.amount, l.interest, l.balance, l.custid  from account a, employee e, loan l where e.ifsc=a.ifsc and a.custid=l.custid and e.ifsc='$ifsc' and l.balance=0";
            $resultx = mysqli_query($db, $query) or die('SQL 1Error: '. mysqli_error($db));

             if (mysqli_multi_query($db, "SELECT idloan, type, amount, interest, balance, custid FROM loanview  order by idloan ")  or die('SQL Error: ' . mysqli_error($db))) {
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
						</tbody>
					</table>
					<br>
				</div>
				<br>
				<button type="button" onclick="window.location.href= 'tabs10.php'" class="cancelbtn">Logout</button>
			</form>
		</div>
	</body>