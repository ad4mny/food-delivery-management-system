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
	<!-- <script src="bootstrap/js/popper.min.js"></script> -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<script>
		$(document).ready(function() {

			//Fetching URL Parameters
			var url_string = window.location.href;
			var url = new URL(url_string);
			var action = url.searchParams.get("act");

			if (action == 'success') {
				$('#alert').html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
					'<strong>Success!</strong>  Your order has been place and please wait patiently, thank you.' +
					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
					'<span aria-hidden="true">&times;</span>' +
					'</button>' +
					'</div>');

			}

			if (action == 'error') {
				$('#alert').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
					'<strong>Error!</strong> Please wait current order to be delivered before placing a new order, thank you.' +
					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
					'<span aria-hidden="true">&times;</span>' +
					'</button>' +
					'</div>');

			}
		});
	</script>

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
				<li class="nav-item ">
					<a class="nav-link" href="checkout">Checkout</a>
				</li>
				<li class="nav-item active">
					<a class="nav-link" href="#">Status<span class="sr-only">(current)</span></a>
				</li>
			</ul>
			<div class="form-inline my-2 my-lg-0">
				<?php
				if (isset($_SESSION['sess_id'])) {
					echo '<a href="action?act=lgout" class="btn btn-outline-success my-2 my-sm-0">Logout</a>';
				} else {
					echo '<a href="index?act=login" class="btn btn-outline-success my-2 my-sm-0">Login</a>';
				}
				?>
			</div>
		</div>
	</nav>

	<!-- Content -->
	<div class=" p-5">

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
					$query = "SELECT * from fds_ordr WHERE ordr_usrdt_id='$usr_id'";
					$result = mysqli_query($conn, $query);
					$count = 1;
					$tot_prc = 0;
					
					if (mysqli_num_rows($result) > 0) {

						while ($row = mysqli_fetch_assoc($result)) {

							$ordr_ctlog_id = $row['ordr_ctlog_id'];

							$query = "SELECT * from fds_ctlog WHERE ctlog_id = '$ordr_ctlog_id'";
							$row_data = mysqli_fetch_assoc(mysqli_query($conn, $query));

							echo '<div class="row border-top py-3">';
							echo '<div class="col-6">' . $row_data['ctlog_nme'] . '</div>';
							echo '<div class="col-2">' . $row_data['ctlog_prc'] . '</div>';
							echo '<div class="col-2">' . $row['ordr_qty'] . '</div>';
							echo '<div class="col-2">' . $row['ordr_stat'] . '</div>';
							echo '</div>';
							$tot_prc += $row_data['ctlog_prc'] * $row['ordr_qty'];
						}

						echo '<div class="row border-top pt-3">';
						echo '<div class="col text-center text-success">Total price: RM ' . round($tot_prc, 1) . '</div>';
						echo '</div>';

						echo '<div class="row pb-5">';
						echo '<div class="col text-center text-muted">Note: Please ready small changes and follow exact total price.</div>';
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
</body>

</html>