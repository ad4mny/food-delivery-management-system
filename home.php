<?php
session_start();
include("db.php");
include("auth.php");

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
		.masthead {
			height: 100vh;
			min-height: 500px;
			background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://source.unsplash.com/fdlZBWIP0aM/1920x1080');
			background-size: cover;
			background-position: center;
			background-repeat: no-repeat;
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
				<li class="nav-item active">
					<a class="nav-link" href="#">Home<span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="browse">Browse</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="checkout">Checkout</a>
				</li>
			</ul>
			<div class="form-inline my-2 my-lg-0">
				<a href="action?act=lgout" class="btn btn-outline-success my-2 my-sm-0">Logout</a>
			</div>
		</div>
	</nav>

	<!-- Content -->
	<!-- Full Page Image Header with Vertically Centered Content -->
	<header class="masthead">
		<div class="container h-100">
			<div class="row h-100 align-items-center">
				<div class="col-12 text-center text-white">
					<h1 class="font-weight-light">Welcome, <?php echo $_SESSION["sess_fullname"]; ?>!</h1>
					<p class="lead">Browse meal to feed your tummy now.</p>
					<button type="button" class="btn btn-outline-light" data-toggle="modal" data-target="#modalUpdateInfo">Update your info</button>
				</div>
			</div>
		</div>
	</header>

	<!-- Page Content -->
	<section class="py-5">
		<div class="container py-2">
			<h2 class="font-weight-light">About Us</h2>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus ab nulla dolorum autem nisi officiis blanditiis voluptatem hic, assumenda aspernatur facere ipsam nemo ratione cumque magnam enim fugiat reprehenderit expedita.</p>
		</div>
		<div class="container py-2">
			<h2 class="font-weight-light">Contact Us</h2>
			<p>+6012-3456789 | example@email.com</p>
		</div>
	</section>

	<!-- Model Login -->
	<div class="modal fade" id="modalUpdateInfo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<form action="" method="post" id="update_form">
					<div class="modal-header text-center">
						<h4 class="modal-title w-100 font-weight-bold">Update your info</h4>
					</div>
					<div class="modal-body mx-3">
						<div class="row">
							<div class="col">
								<label class="sr-only" for="inlineFormInputGroup1"></label>
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fas fa-user"></i></div>
									</div>
									<input type="text" class="form-control" name="fullname" placeholder="Full name" value="<?php echo $_SESSION['sess_fullname']; ?>" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col">
								<div class="input-group mb-2">
									<div class="input-group-prepend">
										<div class="input-group-text"><i class="fas fa-map-marked-alt"></i></div>
									</div>
									<textarea class="form-control" rows="3" id="address" name="address" placeholder="Full address" required><?php echo $_SESSION['sess_address']; ?></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer d-flex justify-content-center">
						<div class="col text-center">
							<input type="hidden" name="update">
							<input type="submit" class="btn btn-default" value="Update">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="bootstrap/js/app.js"></script>
</body>

</html>