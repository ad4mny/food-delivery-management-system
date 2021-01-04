<?php
session_start();
include("db.php");

if (isset($_SESSION["sess_id"])) {
	$usr_id = $_SESSION["sess_id"];
	if ($_SESSION["sess_status"] == "admin") {
		header('location: admin/pnl_user');
	}
	if ($_SESSION["sess_status"] == "shop") {
		header('location: shop/pnl_order');
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="favicon.ico">
	<title>Food Delivery Management System</title>
	<link rel="stylesheet" href="bootstrap/css/all.min.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/jquery-3.4.1.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
</head>

<body class="content bg-white">

	<!-- Navbar -->
	<nav class="navbar navbar-expand-lg navbar-light sticky-top shadow bg-light">
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarTogglerDemo01">
			<a class="navbar-brand" href="#">FOS</a>
			<ul class="navbar-nav mr-auto mt-2 mt-lg-0">
				<li class="nav-item ">
					<a class="nav-link" href="index">Home</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="browse">Browse </a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="checkout">Checkout</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="order">Status</a>
				</li>
			</ul>
			<div class="my-2 my-lg-0">
				<ul class="navbar-nav ml-auto">
					<?php
					if (isset($_SESSION['sess_id'])) {
					?>
						<li class="nav-item dropdown ">
							<a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink-333" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-user"></i> </a>
							<div class="dropdown-menu dropdown-menu-right dropdown-default" aria-labelledby="navbarDropdownMenuLink-333">
								<a class="dropdown-item" href="profile">Profile</a>
								<a class="dropdown-item" href="action?act=lgout">Logout</a>
							</div>
						</li>
					<?php
					} else {
					?>
						<a href="index?act=login" class="btn btn-outline-success my-2 my-sm-0">Login</a>
					<?php
					}
					?>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Content -->
	<div class="container my-5">

		<!-- Alert -->
		<div id="alert" style="position:absolute;z-index:1;">
		</div>

		<h2 class="display-4"><i class="fas fa-tasks"></i> Order Status</h2>

		<div class="row px-3">

			<div class="col">
				<div class="row border-top py-3 font-weight-bold">
					<div class="col-6">Meals Info</div>
					<div class="col-2">Price</div>
					<div class="col-2">Quantity</div>
					<div class="col-2">Status</div>
				</div>

				<?php
				if (isset($usr_id)) {

					$query = "SELECT * from fds_ordr JOIN fds_inv ON fds_ordr.ordr_id=fds_inv.inv_ordr_id WHERE fds_ordr.ordr_usrdt_id='$usr_id' AND fds_ordr.ordr_stat!='Completed'";
					$result = mysqli_query($conn, $query);
					$tot_prc = 0;

					if (mysqli_num_rows($result) > 0) {

						while ($row = mysqli_fetch_assoc($result)) {

							$ordr_ctlog_id = $row['ordr_ctlog_id'];

							$query = "SELECT * from fds_ctlog WHERE ctlog_id = '$ordr_ctlog_id'";
							$row_data = mysqli_fetch_assoc(mysqli_query($conn, $query));

							echo '<div class="row border-top py-3">';
							echo '<div class="col-6 text-capitalize">' . $row_data['ctlog_nme'] . '</div>';
							echo '<div class="col-2">RM ' . number_format((float)($row_data['ctlog_prc']), 2, '.', '') . '</div>';
							echo '<div class="col-2">(' . $row['ordr_qty'] . ')x Order</div>';
							if ($row['ordr_stat'] != "") {
								echo '<div class="col-2">' . $row['ordr_stat'] . '</div>';
							} else {
								echo '<div class="col-2">Preparing</div>';
							}
							echo '</div>';
							$tot_prc += $row_data['ctlog_prc'] * $row['ordr_qty'];
							$payment_type = $row['inv_type'];
						}

						$tot_svc = number_format((float)(10 / 100 * $tot_prc), 2, '.', '');


						echo '<div class="row  border-top pt-3">';

						if ($payment_type == 'paypal') {
							echo '<h4 class="col text-center text-primary">RM ' . number_format((float)(round($tot_prc + $tot_svc, 1)), 2, '.', '') . ' (Paid)</h4>';
							echo '</div>';

							echo '<div class="row">';
							echo '<p class="col text-center ">Pay by Paypal. </p>';
						} else {
							echo '<h4 class="col text-center text-success">RM ' . number_format((float)(round($tot_prc + $tot_svc, 1)), 2, '.', '') . ' (Unpaid)</h4>';
							echo '</div>';

							echo '<div class="row">';
							echo '<p class="col text-center ">Pay by Cash. </p>';
						}
						echo '</div>';

						echo '<div class="row pb-5">';
						echo '<small class="col text-center text-muted">Note: Please ready small changes and follow exact total price.</div>';
						echo '</small>';
					} else {
						echo '<div class="row border-top py-3">';
						echo '<div class="col"> No item has been ordered.</div>';
						echo '</div>';
					}
				} else {
					echo '<div class="row border-top py-3">';
					echo '<div class="col"> No item has been ordered.</div>';
					echo '</div>';
				}
				?>
			</div>
		</div>
	</div>

	<script src="bootstrap/js/app.js"></script>

</body>

</html>