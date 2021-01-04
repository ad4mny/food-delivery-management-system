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
		if (!isset($_SESSION['sess_cart'])) {
			$_SESSION['sess_cart'] = array();
		}
		$_SESSION['sess_cart'][$id] += 1;
		header('location: browse');
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
	<script src="bootstrap/js/popper.min.js"></script>
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<style type="text/css">
		.content {
			background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)),
				url('https://source.unsplash.com/fdlZBWIP0aM/1920x1080');
			height: 100%;
			background-position: center;
			background-repeat: repeat;
		}
	</style>
</head>

<body class="content">

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
				<li class="nav-item active">
					<a class="nav-link" href="#">Browse <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="checkout">Checkout</a>
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
	<div class="container p-5" id="browse_box">
		<div class="row">
			<div class="col-9">
				<h2 class="display-4 text-light">Browse</h2>
			</div>
			<div class="col-3">
				<div class="input-group mt-4">
					<input type="text" id="search_query" class="form-control" placeholder="Search..">
					<div class="input-group-append">
						<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Filter</button>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="browse?q_filter=name">Name</a>
							<a class="dropdown-item" href="browse?q_filter=shop">Shop</a>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php

		$query = "SELECT * from fds_ctlog";
		$result = mysqli_query($conn, $query);

		$tot_item = mysqli_num_rows($result);

		?>
		<div class="row">
			<div class="col">
				<div class="card-columns" id="display_area">
					<?php
					while ($row = mysqli_fetch_assoc($result)) {

						$itm_id = $row['ctlog_id'];
						$itm_name = $row['ctlog_nme'];
						$itm_prc = $row['ctlog_prc'];
						$itm_desc = $row['ctlog_desc'];
						$itm_shp = $row['ctlog_shp'];
						$itm_img = $row['ctlog_img'];

					?>

						<div class="card " style="width: 18rem;">

							<?php

							if ($itm_img != null) {

								echo '<img class="card-img-top" src="img/menu/' . $itm_img . '" alt="Card image cap">';
							} else {

								echo '<img class="card-img-top" src="https://dummyimage.com/640x360/f0f0f0/aaa" alt="Card image cap">';
							}

							?>

							<div class="card-body">
								<h5 class="card-title text-capitalize"><?php echo $itm_name; ?></h5>
								<p class="card-text text-muted"><?php echo $itm_desc; ?></p>
								<p class="card-text text-capitalize"><?php echo $itm_shp . "'s Shop"; ?></p>
							</div>
							<div class="card-footer text-right" id="<?php echo encryptIt($itm_id); ?>">
								<h5 class="card-text float-left text-success">RM <?php echo number_format($itm_prc, 2); ?></h5>
								<a href="browse?act=add&id=<?php echo encryptIt($itm_id); ?>" class="btn btn-success ">Add to cart</a>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>

	<!-- Script -->
	<script src="bootstrap/js/app.js"></script>
</body>

</html>