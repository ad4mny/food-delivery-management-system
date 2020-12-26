<?php
session_start();
include('../db.php');
$usr_id = $_SESSION['sess_id'];
$id = decryptIt($_GET['id']);

if (isset($_POST['submit'])) {

	$nme = $_POST['ctlog_nme'];
	$prc = $_POST['ctlog_prc'];
	$desc = $_POST['ctlog_desc'];
	$shp = $_SESSION['sess_fullname'];


	if (!empty($_FILES['ctlog_img']['name'])) {

		//Fetch file info
		$file_name = $_FILES['ctlog_img']['name'];
		$file_tmp = $_FILES['ctlog_img']['tmp_name'];

		$newdir = '../img/menu';

		if (!file_exists($newdir)) {
			mkdir($newdir, 0744);
		}

		move_uploaded_file($file_tmp, "../img/menu/" . $file_name);

		$query = "UPDATE fds_ctlog SET ctlog_img = '$file_name', ctlog_nme = '$nme', ctlog_prc = '$prc', ctlog_desc = '$desc', 
		ctlog_shp = '$shp', ctlog_log = '$date' WHERE ctlog_id = '$id'";
		$result = mysqli_query($conn, $query);

		header('location: pnl_catalog');
		exit();
	} else {

		$query = "UPDATE fds_ctlog SET ctlog_nme = '$nme', ctlog_prc = '$prc', ctlog_desc = '$desc', ctlog_shp = '$shp', ctlog_log = '$date' WHERE ctlog_id = '$id'";
		$result = mysqli_query($conn, $query);

		header('location: pnl_catalog');
		exit();
	}
}

if ($_GET['act'] == 'delctlog') {

	$query = "SELECT ctlog_img from fds_ctlog WHERE ctlog_id = '$id'";
	$data = mysqli_fetch_assoc(mysqli_query($conn, $query));
	$file_name = $data["ctlog_img"];

	$query = "DELETE FROM fds_ctlog WHERE ctlog_id = '$id'";
	$result = mysqli_query($conn, $query);

	if ($file_name != null && $result) {
		unlink('../img/menu/' . $file_name);
	}

	header('location: pnl_catalog');
	exit();
}

if ($_GET['act'] == 'addctlog') {

	$query = "INSERT INTO fds_ctlog (ctlog_usrdt_id, ctlog_log) VALUES('$usr_id','$date')";
	mysqli_query($conn, $query) or die($query . '  ERROR!');

	header('location: pnl_catalog');
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
					<li class="list-group-item"><a href="pnl_order">Order Panel</a></li>
					<li class="list-group-item"><a href="pnl_catalog">Catalog Panel</a></li>
					<li class="list-group-item"><a href="../action?act=lgout" class="text-danger">Logout</a></li>
				</ul>
			</div>
		</div>

		<div class="row p-4">
			<div class="col">
				<h2 class="border-bottom">catalog update</h2>

				<form action="" method="post" enctype="multipart/form-data">

					<?php
					$query = "SELECT * from fds_ctlog WHERE ctlog_id='$id'";
					$result = mysqli_query($conn, $query);

					if (mysqli_num_rows($result) > 0) {

						$row = mysqli_fetch_assoc($result);

					?>

						<div class="row py-2">
							<div class="col-2">
								<div>picture</div>
							</div>
							<div class="col-3">

								<?php echo '<img class="img-fluid" width="150" src="../img/menu/' . $row['ctlog_img'] . '" alt="no image">'; ?>
								<input type="file" name="ctlog_img" id="ctlog_img">

							</div>
						</div>

						<div class="row py-2">
							<div class="col-2">
								<div>name</div>
							</div>
							<div class="col-3">
								<?php echo '<input type="text" class="form-control" name="ctlog_nme" value="' . $row['ctlog_nme'] . '">' ?>
							</div>
						</div>

						<div class="row py-2 ">
							<div class="col-2">
								<div>price</div>
							</div>
							<div class="col-3">
								<?php echo '<input type="text" class="form-control" name="ctlog_prc" value="' . $row['ctlog_prc'] . '">' ?>
							</div>
						</div>

						<div class="row py-2">
							<div class="col-2">
								<div>description</div>
							</div>
							<div class="col-3">
								<?php echo '<textarea rows="3" class="form-control" name="ctlog_desc">' . $row['ctlog_desc'] . '</textarea>' ?>
							</div>
						</div>

						<div class="row py-2">
							<div class="col">
								<input type="hidden" name="ctlog_id" value="<?php echo $row['ctlog_id']; ?>">
								<input type="submit" name="submit" class="btn btn-info" value="Update">

								<a class="btn btn-danger" href="pnl_catalog_update?act=delctlog&id='<?php echo encryptIt($row['ctlog_id']); ?>'">Delete</a>
							</div>
						</div>
					<?php
					}
					?>
				</form>
			</div>
		</div>
	</div>
</body>

</html>