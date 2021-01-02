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

if (isset($_GET['id'])) {
	$id = $_GET['id'];
}

if (isset($_GET['act'])) {

	if ($_GET['act'] == 'add') {
		$_SESSION['sess_cart'][$id] += 1;
		header('location: checkout');
	}

	if ($_GET['act'] == 'del') {
		$_SESSION['sess_cart'][$id] -= 1;
		if ($_SESSION['sess_cart'][$id] == 0) {
			unset($_SESSION['sess_cart'][$id]);
		}
		header('location: checkout');
	}

	if ($_GET['act'] == 'payment') {

		if (isset($_GET['flag']) == 'pay') {

			$time = $_GET['ordertime'];

			if (isset($_SESSION['sess_id'])) {

				$query = "SELECT * from fds_ordr WHERE ordr_usrdt_id='$usr_id'";
				$result = mysqli_query($conn, $query);

				if (mysqli_num_rows($result) > 0) {
					unset($_SESSION['sess_cart']);
					header('location: checkout?act=error');
					exit();
				} else {
					foreach ($_SESSION['sess_cart'] as $key => $data) {

						$ctlog_id = decryptIt($key);

						$query = "INSERT INTO fds_ordr (ordr_usrdt_id, ordr_ctlog_id, ordr_qty, ordr_dte, ordr_pick) 
									VALUES('$usr_id', '$ctlog_id', '$data', '$date','$time')";
						mysqli_query($conn, $query) or die($query . '  ERROR!');
						$inv_ordr_id = mysqli_insert_id($conn);

						$query = "SELECT ctlog_prc FROM fds_ctlog WHERE ctlog_id = '$ctlog_id'";
						$row = mysqli_fetch_assoc(mysqli_query($conn, $query));

						$total_amount = $row['ctlog_prc'] * $data;

						if ($_GET['return'] == 'paypal') {
							$query = "INSERT INTO fds_inv (inv_ordr_id, inv_pay_stat, inv_amt, inv_type, inv_dte) 
									VALUES('$inv_ordr_id', 'paid', '$total_amount', 'paypal', '$date')";
							mysqli_query($conn, $query);
						} else {
							$query = "INSERT INTO fds_inv (inv_ordr_id, inv_pay_stat, inv_amt, inv_type, inv_dte) 
									VALUES('$inv_ordr_id', 'none', '$total_amount', 'cash', '$date')";
							mysqli_query($conn, $query);
						}
					}
					unset($_SESSION['sess_cart']);
					header('location: checkout?act=success');
					exit();
				}
			} else {
				echo '<script>alert("Please login first to make an order.")</script>';
			}
		} else {
			header('location: checkout?act=cancel');
			exit();
		}
	}
}

?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="favicon.ico">
	<title>Food Ordering Management System</title>
	<link rel="stylesheet" href="bootstrap/css/all.min.css">
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<script src="bootstrap/js/jquery-3.4.1.min.js"></script>
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

			if (action == 'cancel') {
				$('#alert').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
					'<strong>Payment failed!</strong>  Payment has been canceled.' +
					'<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
					'<span aria-hidden="true">&times;</span>' +
					'</button>' +
					'</div>');

			}
		});
	</script>

</head>

<body class="content bg-light">

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
				<li class="nav-item active">
					<a class="nav-link" href="#">Checkout<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="order">Status</a>
				</li>
			</ul>
			<div class="my-2 my-lg-0">
				<ul class="navbar-nav ml-auto">
					<?php
					if (isset($_SESSION['sess_id'])) {
					?>
						<li class="nav-item dropdown">
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
						<a href="" class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#modalLoginForm">Login</a>
					<?php
					}
					?>
				</ul>
			</div>
		</div>
	</nav>

	<!-- Content -->
	<div class="container pt-5">

		<!-- Alert -->
		<div id="alert" style="position:absolute;z-index:1;">
		</div>

		<h2 class="display-4">Checkout Cart</h2>

		<table id="cart" class="table table-hover table-condensed">

			<tr>
				<th style="width:65%">Meals Info</th>
				<th style="width:10%">Price</th>
				<th style="width:10%">Quantity</th>
				<th style="width:15%" class="text-center">Subtotal</th>
			</tr>

			<?php

			if (!empty($_SESSION['sess_cart'])) {

				$tot_prc = 0;

				foreach ($_SESSION['sess_cart'] as $key => $data) {

					$ctlog_id = decryptIt($key);

					$query = "SELECT * from fds_ctlog WHERE ctlog_id = '$ctlog_id'";
					$row = mysqli_fetch_assoc(mysqli_query($conn, $query));

			?>

					<tr>
						<td data-th="Product">
							<div class="row">

								<?php

								if ($row['ctlog_img'] != null) {

									echo '<div class="col-3 hidden-xs"><img src="img/menu/' . $row['ctlog_img'] .
										'" alt="No available Image" class="img-fluid"/></div>';
								} else {

									echo '<div class="col-3 hidden-xs"><img src="http://placehold.it/100x100" 
										alt="No available Image" class="img-fluid"/></div>';
								}

								?>

								<div class="col">
									<h4 class="nomargin"><?php echo $row['ctlog_nme']; ?></h4>
									<p><?php echo $row['ctlog_desc']; ?></p>
								</div>
							</div>
						</td>
						<td data-th="Price"><?php echo $row['ctlog_prc']; ?></td>
						<td data-th="Quantity">
							<nav>
								<ul class="pagination">
									<li class="page-item"><a class="page-link" href="checkout?act=del&id=<?php echo $key; ?>">-</a></li>
									<li class="page-item disabled"><a class="page-link" href="#"><?php echo $data; ?></a></li>
									<li class="page-item"><a class="page-link" href="checkout?act=add&id=<?php echo $key; ?>">+</a></li>
								</ul>
							</nav>
						</td>
						<td data-th="Subtotal" class="text-center"><?php echo $row['ctlog_prc'] * $data; ?></td>
					</tr>

			<?php

					$tot_prc = $tot_prc + $row['ctlog_prc'] * $data;
				}
			} else {

				echo '<tr><td colspan="5"><p>Nothing yet in your cart :( <br><small> Order some meal now!</small></p></td></tr>';
			}

			?>

			<tr>
				<td colspan="3" class="hidden-xs"></td>
				<td class="hidden-xs text-center"><strong>Total RM <?php echo round($tot_prc); ?></strong></td>
				<td><a href="checkout?act=confirm" class="btn btn-success btn-block">Checkout <i class="fa fa-angle-right"></i></a></td>
			</tr>
		</table>

	</div>
	<script type="text/javascript">
		$(document).ready(function() {

			$('#checkout').on('click', function() {
				$('#ordertime').attr('value', $('#timeorder').val());
				if ($('#timeorder').val() == '') {
					alert("Please enter pickup time.");
				}
			});

			$("input[name='payment']").change(function(e) {
				var payment_type = $("input[name='payment']:checked").val();
				console.log(payment_type);

				if (payment_type == "cash") {
					$("#cash").show();
					$("#paypal").hide();
				} else {
					$("#cash").hide();
					$("#paypal").show();
				}
			});
		});
	</script>

</body>

</html>