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
				<div class="imgcontainer"> <span onclick="window.location.href = 'tabs1.php'" class="close" title="Close">&times;</span> </div>
				<div class="container">
					<table class="data-table">
						<caption class="title" style="text-align: center; font-size: 20px; ">Loans taken</caption>
						<thead>
							<tr>
								<th>Loan_id</th>
								<th>Type</th>
								<th>Amount</th>
								<th>Interest</th>
								<th>Balance</th>
							</tr>
						</thead>
						<tbody>
							<?php
							error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE ^ E_STRICT);
							include("dbcon.php");
							$custid = $_SESSION['custid'];
							$custid = mysqli_real_escape_string($db, $custid);
							if (mysqli_multi_query($db, "SELECT * from loan where custid='$custid' ")  or die('SQL Error: ' . mysqli_error($db))) {
								do {
									/* store first result set */
									if ($result1 = mysqli_store_result($db)) {
										while ($row = mysqli_fetch_row($result1)) {
											echo '<tr>
											<td>'.$row[0].'</td>
											<td>'.$row[1].'</td>
											<td>'.$row[2].'</td>
											<td>'.$row[3].'</td>
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
				</div>
				<br>
			</form>
		</div>
	</body>