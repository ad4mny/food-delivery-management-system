<?php
include ('../db.php');


if ($_GET['act'] == 'delusr') {

	$id = decryptIt($_GET['id']);

	$query = "DELETE FROM fds_usrdt WHERE usrdt_id = '$id'";
	$result = mysqli_query($conn, $query);

	header ('location: pnl_user');
	exit();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../favicon.ico">
	<title>admin@fds</title>
	<link rel="stylesheet" href="../bootstrap/css/all.min.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<script src="../bootstrap/js/jquery-3.4.1.min.js"></script>
</head>
<body>
	<div class="container">

		<div class="row p-4">
			<div class="col">
				<ul class="list-group list-group-horizontal">
					<li class="list-group-item active"><a href="#" class=" text-white">User Panel</a></li>
					<li class="list-group-item "><a href="pnl_order">Order Panel</a></li>
					<li class="list-group-item "><a href="pnl_catalog">Catalog Panel</a></li>
					<li class="list-group-item"><a href="../action?act=lgout" class="text-danger">Logout</a></li>
				</ul>
			</div>
		</div>


		<div class="row p-4">
			<div class="col">
				<h2>user list</h2>
				<table class="table">
					<tr>
						<th>no.</th>
						<th>name</th>
						<th>username</th>
						<th>address</th>
						<th>stat</th>
						<th>action</th>
					</tr>

					<?php

					$query = "SELECT * from fds_usrdt WHERE usrdt_stat!='admin'";
					$result = mysqli_query($conn, $query);
					$count = 1;
					if (mysqli_num_rows($result) > 0) {
						while($row = mysqli_fetch_assoc($result)){

							echo '<tr>';
							echo '<td>' . $count++ . '</td>';
							echo '<td>' . $row['usrdt_nme'] . '</td>';
							echo '<td>' . $row['usrdt_usr'] . '</td>';
							echo '<td>' . $row['usrdt_adrs'] . '</td>';
							echo '<td>' . $row['usrdt_stat'] . '</td>';
							echo '<td><a href="pnl_user?act=delusr&id=' . encryptIt($row['usrdt_id']) . '" onclick="return confirm()">Delete</a></td>';
							echo '</tr>';

						}
					}

					?>
				</table>
			</div>
		</div>

	</div>

</body>
</html>