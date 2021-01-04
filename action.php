<?php
session_start();
include("db.php");

if (isset($_GET['act'])) {
	if ($_GET['act'] == 'lgout') {

		session_destroy();
		header("Location: index");
	}
}


if (isset($_POST['signup'])) {

	if ($_POST['signup'] == 'user') {

		if ((!empty($_POST['username'])) && (!empty($_POST['password']))) {

			$usr = stripslashes($_REQUEST['username']);
			$usr = mysqli_real_escape_string($conn, $usr);
			$pwd = stripslashes($_REQUEST['password']);
			$pwd = md5(mysqli_real_escape_string($conn, $pwd));
			$name = stripslashes($_REQUEST['fullname']);
			$name = mysqli_real_escape_string($conn, $name);
			$address = stripslashes($_REQUEST['address']);
			$address = mysqli_real_escape_string($conn, $address);

			$query = "INSERT INTO fds_usrdt (usrdt_nme,usrdt_usr,usrdt_pwd,usrdt_adrs,usrdt_stat,usrdt_log) 
		VALUES('$name','$usr','$pwd','$address','user','$date')";
			$result = mysqli_query($conn, $query);

			if ($result) {

				$query = "SELECT * FROM fds_usrdt WHERE usrdt_usr='$usr' AND usrdt_pwd='$pwd'";
				$result = mysqli_query($conn, $query) or die($query . '  ERROR!');
				$data = mysqli_fetch_assoc($result);

				$_SESSION['sess_id'] = $data["usrdt_id"];
				$_SESSION['sess_username'] = $data["usrdt_usr"];
				$_SESSION['sess_fullname'] = $data["usrdt_nme"];
				$_SESSION['sess_status'] = $data["usrdt_stat"];
				$_SESSION['sess_address'] = $data["usrdt_adrs"];
			}

			echo 'true';
		}
	}


	if ($_POST['signup'] == 'vendor') {

		if ((!empty($_POST['shop_username'])) && (!empty($_POST['shop_password']))) {

			$usr = stripslashes($_REQUEST['shop_username']);
			$usr = mysqli_real_escape_string($conn, $usr);
			$pwd = stripslashes($_REQUEST['shop_password']);
			$pwd = md5(mysqli_real_escape_string($conn, $pwd));
			$name = stripslashes($_REQUEST['shop_name']);
			$name = mysqli_real_escape_string($conn, $name);

			$query = "INSERT INTO fds_usrdt (usrdt_nme,usrdt_usr,usrdt_pwd,usrdt_adrs,usrdt_stat,usrdt_log) 
		VALUES('$name','$usr','$pwd','KK3 CAFE','shop','$date')";
			$result = mysqli_query($conn, $query);

			if ($result) {

				$query = "SELECT * FROM fds_usrdt WHERE usrdt_usr='$usr' AND usrdt_pwd='$pwd'";
				$result = mysqli_query($conn, $query) or die($query . '  ERROR!');
				$data = mysqli_fetch_assoc($result);

				$_SESSION['sess_id'] = $data["usrdt_id"];
				$_SESSION['sess_username'] = $data["usrdt_usr"];
				$_SESSION['sess_fullname'] = $data["usrdt_nme"];
				$_SESSION['sess_status'] = $data["usrdt_stat"];
			}

			echo 'true';
		}
	}
}


if (isset($_POST['login'])) {

	$usr = stripslashes($_REQUEST['username']);
	$usr = mysqli_real_escape_string($conn, $usr);
	$pwd = stripslashes($_REQUEST['password']);
	$pwd = md5(mysqli_real_escape_string($conn, $pwd));

	$query = "SELECT * FROM fds_usrdt WHERE usrdt_usr='$usr' AND usrdt_pwd='$pwd'";
	$result = mysqli_query($conn, $query) or die($query . '  ERROR!');

	if (mysqli_num_rows($result) > 0) {

		$data = mysqli_fetch_assoc($result);

		$_SESSION['sess_id'] = $data["usrdt_id"];
		$_SESSION['sess_username'] = $data["usrdt_usr"];
		$_SESSION['sess_fullname'] = $data["usrdt_nme"];
		$_SESSION['sess_status'] = $data["usrdt_stat"];
		$_SESSION['sess_address'] = $data["usrdt_adrs"];

		echo 'true';
	} else {

		echo 'false';
	}
}


if (isset($_POST['update'])) {

	if ((!empty($_POST['fullname'])) && (!empty($_POST['address'])) && (!empty($_POST['usr'])) && (!empty($_POST['pwd']))) {

		$name = $_POST['fullname'];
		$address = $_POST['address'];
		$usr = $_POST['usr'];
		$pwd = md5($_POST['pwd']);
		$id = $_SESSION['sess_id'];

		$query = "UPDATE fds_usrdt SET usrdt_nme = '$name', usrdt_adrs = '$address', usrdt_usr = '$usr' , usrdt_pwd = '$pwd'  WHERE usrdt_id = '$id'";
		$result = mysqli_query($conn, $query);

		$_SESSION['sess_username'] = $usr;
		$_SESSION['sess_fullname'] = $name;
		$_SESSION['sess_address'] = $address;

		echo json_encode($result);
	}
}

if (isset($_POST['data'])) {

	if ($_POST['data'] == 'chk_usr') {

		$usr = $_POST['temp_usr'];

		$query = "SELECT * from fds_usrdt WHERE usrdt_usr = '$usr'";
		$result = mysqli_fetch_assoc(mysqli_query($conn, $query));

		echo json_encode($result);
	}


	if ($_POST['data'] == 'get_menu') {

		$mid = decryptIt($_POST['menu_id']);

		$query = "SELECT * from fds_ctlog WHERE ctlog_id = '$mid'";
		$result = mysqli_fetch_assoc(mysqli_query($conn, $query));

		echo json_encode($result);
	}


	if ($_POST['data'] == 's_query') {

		$s_data = $_POST['s_data'];
		$q_data = $_POST['q_filter'];

		if ($q_data == 'shop') {

			$query = "SELECT * from fds_ctlog WHERE ctlog_shp LIKE '%$s_data%'";
			$result = mysqli_query($conn, $query);

			if (mysqli_num_rows($result) > 0) {

				$key = 0;
				while ($row = mysqli_fetch_assoc($result)) {

					$new_data[$key]['ctlog_id'] = encryptIt($row['ctlog_id']);
					$new_data[$key]['ctlog_nme'] = $row['ctlog_nme'];
					$new_data[$key]['ctlog_img'] = $row['ctlog_img'];
					$new_data[$key]['ctlog_prc'] = $row['ctlog_prc'];
					$new_data[$key]['ctlog_desc'] = $row['ctlog_desc'];
					$new_data[$key]['ctlog_shp'] = $row['ctlog_shp'];

					$key++;
				};


				echo json_encode($new_data);
			} else {

				echo json_encode('none');
			}
		} else {

			$query = "SELECT * from fds_ctlog WHERE ctlog_nme LIKE '$s_data%'";
			$result = mysqli_query($conn, $query);

			if (mysqli_num_rows($result) > 0) {

				$key = 0;
				while ($row = mysqli_fetch_assoc($result)) {

					$new_data[$key]['ctlog_id'] = encryptIt($row['ctlog_id']);
					$new_data[$key]['ctlog_nme'] = $row['ctlog_nme'];
					$new_data[$key]['ctlog_img'] = $row['ctlog_img'];
					$new_data[$key]['ctlog_prc'] = $row['ctlog_prc'];
					$new_data[$key]['ctlog_desc'] = $row['ctlog_desc'];
					$new_data[$key]['ctlog_shp'] = $row['ctlog_shp'];

					$key++;
				};


				echo json_encode($new_data);
			} else {

				echo json_encode('none');
			}
		}
	}
	
}
