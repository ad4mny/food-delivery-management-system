<?php
include ('../db.php');


if ($_GET['act'] == 'ordrdel') {

	$id = decryptIt($_GET['id']);

	$query = "DELETE FROM fds_ordr WHERE ordr_usrdt_id = '$id'";
	$result = mysqli_query($conn, $query);

	header ('location: pnl_order');
	exit();
}

if ($_GET['act'] == 'ordrrdy') {

	$id = decryptIt($_GET['id']);

	$query = "UPDATE fds_ordr SET ordr_stat='ready' WHERE ordr_usrdt_id = '$id'";
	$result = mysqli_query($conn, $query);

	header ('location: pnl_order');
	exit();
}


?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="../favicon.ico">
	<title>shop@fds</title>
	<link rel="stylesheet" href="../bootstrap/css/all.min.css">
	<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
	<script src="../bootstrap/js/jquery-3.4.1.min.js"></script>
</head>
<body>
	<div class="container">

		<div class="row p-4">
			<div class="col">
				<ul class="list-group list-group-horizontal">
					<li class="list-group-item active"><a href="#" class=" text-white">Order Panel</a></li>
					<li class="list-group-item "><a href="pnl_catalog">Catalog Panel</a></li>
					<li class="list-group-item"><a href="../action?act=lgout" class="text-danger">Logout</a></li>
				</ul>
			</div>
		</div>


		<div class="row p-4">
			<div class="col">
				<h2>order list</h2>
				<table class="table">
					<tr>
						<th>no.</th>
						<th>name & address</th>
						<th>meal, shop & quantity</th>
						<th>status</th>
						<th>action</th>
					</tr>

					<?php

					$count = 1;

					$query = "SELECT fds_usrdt.usrdt_nme as 'usr_nme', fds_usrdt.usrdt_adrs as 'usr_add', fds_usrdt.usrdt_id as 'usr_id', GROUP_CONCAT(ordr_ctlog_id) as ordr_list, GROUP_CONCAT(ordr_stat) as ordr_stat, GROUP_CONCAT(ordr_qty) as ordr_qty FROM fds_ordr JOIN fds_usrdt ON fds_ordr.ordr_usrdt_id = fds_usrdt.usrdt_id WHERE fds_ordr.ordr_usrdt_id = fds_usrdt.usrdt_id GROUP BY fds_ordr.ordr_usrdt_id";
					$result = mysqli_query($conn, $query);
					$order_list = array();


					if (mysqli_num_rows($result) > 0) {

						while($row = mysqli_fetch_assoc($result)) {

							$order_list = explode(",", $row['ordr_list']);
							$order_qty = explode(",", $row['ordr_qty']);

							echo '<tr>';
							echo '<td>' . $count++ . '</td>';
							echo '<td>' . $row['usr_nme'] . '<hr>' . $row['usr_add']  .  '</td>';
							echo '<td>';
							for($i = 0; $i < sizeof($order_list); $i++) {

								$ctlog_id = $order_list[$i];
								$query = "SELECT * FROM fds_ctlog WHERE ctlog_id = '$ctlog_id'";
								$data = mysqli_fetch_assoc(mysqli_query($conn, $query));

								echo '<p><span class="text-info">' . $data['ctlog_nme'] . '</span>; ' . $data['ctlog_shp'] . ' (' . $order_qty[$i] . ' Qty)</p>';

							}
							echo '</td>';
							if ($row['ordr_stat'] == null) {
								echo '<td><p class="text-warning">pending</p></td>';
							} else {
								echo '<td><p class="text-success">ready</p></td>';
							}

							echo '<td><a href="pnl_order?act=ordrrdy&id=' . encryptIt($row['usr_id']) . '" onclick="return confirm()">Mark ready</a><br><a href="pnl_order?act=ordrdel&id=' . encryptIt($row['usr_id']) . '" onclick="return confirm()">Delete order</a></td>';
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