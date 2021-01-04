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

						$query = "INSERT INTO fds_ordr (ordr_usrdt_id, ordr_ctlog_id, ordr_qty, ordr_dte) 
									VALUES('$usr_id', '$ctlog_id', '$data', '$date')";
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
				header('Location: checkout?act=not_login');
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
						<a href="index?act=login" class="btn btn-outline-success my-2 my-sm-0">Login</a>
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

		<h2 class="display-4"><i class="fas fa-shopping-cart"></i> Checkout Cart</h2>

		<table id="cart" class="table table-hover table-condensed">
			<tr>
				<th style="width:60%">Meals Info</th>
				<th style="width:10%">Price</th>
				<th style="width:15%">Quantity</th>
				<th style="width:15%">Subtotal</th>
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
						<td>
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
									<h4 class="text-capitalize"><?php echo $row['ctlog_nme']; ?></h4>
									<p><?php echo $row['ctlog_desc']; ?></p>
								</div>
							</div>
						</td>
						<td><?php echo number_format((float)$row['ctlog_prc'], 2, '.', ''); ?></td>
						<td>
							<ul class="pagination">
								<li class="page-item"><a class="page-link" href="checkout?act=del&id=<?php echo $key; ?>">-</a></li>
								<li class="page-item disabled"><a class="page-link" href="#"><?php echo $data; ?></a></li>
								<li class="page-item"><a class="page-link" href="checkout?act=add&id=<?php echo $key; ?>">+</a></li>
							</ul>
						</td>
						<td>
							<?php echo number_format((float)($row['ctlog_prc'] * $data), 2, '.', ''); ?>
						</td>
					</tr>
			<?php

					$tot_prc = $tot_prc + $row['ctlog_prc'] * $data;
				}
			} else {

				echo '<tr><td colspan="5"><p>Nothing yet in your cart :( <br><small> Order some meal now!</small></p></td></tr>';
			}

			?>
			<tr>
				<td colspan="2" class="hidden-xs"></td>
				<td>
					<span>Subtotal</span></br>
					<span>Service Charge</span></br>
					<span>Total</span>
				</td>
				<td>
					<span>
						<?php if (isset($tot_prc)) {
							echo number_format((float)($tot_prc), 2, '.', '');
						} ?>
					</span></br>
					<span>
						<?php if (isset($tot_prc)) {
							$tot_svc = number_format((float)(10 / 100 * $tot_prc), 2, '.', '');
							echo $tot_svc;
						} ?>
					</span></br>
					<h4 class="text-success"> RM
						<?php if (isset($tot_prc)) {
							echo number_format((float)(round($tot_prc + $tot_svc, 1)), 2, '.', '');
						} ?>
					</h4>
				</td>
			</tr>
			<?php

			if (isset($_SESSION['sess_cart'])) {

			?>
				<tr>
					<td colspan="2" class="hidden-xs"></td>
					<td colspan="2">
						<div class="form-group">
							<label class=" mr-4"><input type="radio" class="form-input" name="payment" value="cash" checked>
								<i class="fas fa-wallet"></i> Cash </label>
							<label><input type="radio" class="form-input" name="payment" value="paypal">
								<i class="fab fa-cc-paypal"></i> Paypal</label>
						</div>
						<div id="cash">
							<form action="checkout" method="get">
								<input type="hidden" name="ordertime" id="ordertime">
								<input type="hidden" name="flag" value="pay">
								<input type="hidden" name="return" value="cash">
								<input type="hidden" name="act" value="payment">
								<button type="submit" class="btn btn-success btn-block" id="checkout"> Confirm Order
									<i class="fa fa-angle-right"></i></button>
							</form>
						</div>
						<div id="paypal" style="display: none;">
							<form action="<?php echo PAYPAL_URL; ?>" method="post">
								<input type="hidden" name="business" value="<?php echo PAYPAL_ID; ?>">
								<input type="hidden" name="cmd" value="_xclick">
								<input type="hidden" name="item_name" value="<?php echo 'mehOrder Takeaway Services'; ?>">
								<input type="hidden" name="item_number" value="">
								<input type="hidden" name="amount" value="<?php echo $tot_prc; ?>">
								<input type="hidden" name="currency_code" value="<?php echo PAYPAL_CURRENCY; ?>">

								<input type="hidden" name="return" value="<?php echo PAYPAL_RETURN_URL; ?>">
								<input type="hidden" name="cancel_return" value="<?php echo PAYPAL_CANCEL_URL; ?>">
								<input type="submit" name="submit" class="btn btn-primary btn-block" value="Pay Now">
							</form>
						</div>
					</td>
				</tr>
			<?php
			}


			?>
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

	<script src="bootstrap/js/app.js"></script>

</body>

</html>