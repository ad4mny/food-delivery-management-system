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
} else {
    header('location: index');
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
                <li class="nav-item">
                    <a class="nav-link" href="browse">Browse </a>
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
                        <li class="nav-item dropdown active">
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

        <h2 class="display-4 text-white">Profile</h2>

        <div class="row bg-light rounded p-5">

            <div class="col-4 " id="profile_display">
                <h4 class="pb-3 text-capitalize">Hi, <?php echo $_SESSION["sess_username"]; ?>.</h4>
                <div class="form-group ">
                    <div class="mb-1 "><i class="fas fa-user"></i> Full Name</div>
                    <div class="text-muted  text-capitalize"> <?php echo $_SESSION["sess_fullname"]; ?></div>
                </div>
                <div class="form-group ">
                    <div class="mb-1 "><i class="fas fa-map-marked-alt"></i> Address</div>
                    <div class="text-muted  text-capitalize"> <?php echo $_SESSION["sess_address"]; ?></div>
                </div>
                <div class="form-group ">
                    <a href="profile?act=update"><small>Edit profile</small></a>
                </div>
            </div>

            <div class="col-4 " id="update_display" style="display: none;">
                <form action="" method="POST" id="update_form">
                    <h4 class="pb-3 text-capitalize">Update your profile.</h4>
                    <div class="form-group font-weight-light">
                        <div class="mb-1 "><i class="fas fa-user"></i> Full Name</div>
                        <div class="text-muted  text-capitalize"> </div>
                        <div class="input-group">
                            <input type="text" class="form-control" name="fullname" placeholder="Change full name." value=" <?php echo $_SESSION["sess_fullname"]; ?>" required>
                        </div>
                    </div>
                    <div class="form-group font-weight-light">
                        <div class="mb-1 "><i class="fas fa-map-marked-alt"></i> Address</div>
                        <textarea class="form-control" name="address" placeholder="Max 50 characters." row="2" cols="50" maxlength="50" required><?php echo $_SESSION["sess_address"]; ?></textarea>
                    </div>
                    <div class="form-group font-weight-light">
                        <div class="mb-1 "><i class="fas fa-user-alt"></i> Username</div>
                        <input type="text" class="form-control" name="usr" id="usr" placeholder="Change your username." value="<?php echo $_SESSION["sess_username"]; ?>" required>
                    </div>
                    <div class="form-group font-weight-light">
                        <div class="mb-1 "><i class="fas fa-lock"></i> Password</div>
                        <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Enter your password." value="" required>
                    </div>
                    <div class="form-group font-weight-light">
                        <input type="hidden" name="update">
                        <button type="submit" class="form-control btn btn-primary">Update Profile <i class="fas fa-chevron-right"></i></button>
                    </div>
                </form>
            </div>

            <div class="col border-left">
                <h4 class="pb-2">Current Order</h4>
                <div class="p-2">
                    <?php

                    $query = "select * FROM fds_ordr JOIN fds_ctlog ON fds_ctlog.ctlog_id=fds_ordr.ordr_ctlog_id WHERE ordr_usrdt_id='$usr_id' AND ordr_stat='Preparing' ORDER BY ordr_id DESC";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {

                            echo '<div class="row shadow mb-1 bg-white rounded">';

                            if ($row['ctlog_img'] != null) {
                                echo '<div class="col-3"><img class="img-fluid" src="img/menu/' . $row['ctlog_img'] . '" alt="Image Unavailable"></div>';
                            } else {
                                echo '<div class="col-3"><img class="img-fluid" src="https://dummyimage.com/640x360/f0f0f0/aaa" alt="Image Unavailable"></div>';
                            }

                            echo '<div class="col-7 text-capitalize">' . $row['ctlog_nme'] .
                                '<br><small class="text-muted">' . $row['ctlog_desc'] . '</small></div>';
                            echo '<div class="col-2 text-muted font-italic"><small >' . $row['ordr_stat'] . '</small>
							<br><small class="text-muted">' . $row['ordr_qty'] . ' Order(s)</small></div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p class=''> No order made yet.</p>";
                    }
                    ?>
                </div>
                <h4 class="pb-2">Order History</h4>
                <div class="p-2">
                    <?php

                    $query = "select * FROM fds_ordr JOIN fds_ctlog ON fds_ctlog.ctlog_id=fds_ordr.ordr_ctlog_id WHERE ordr_usrdt_id='$usr_id' AND ordr_stat='Completed' ORDER BY ordr_id DESC";
                    $result = mysqli_query($conn, $query);

                    if (mysqli_num_rows($result) > 0) {

                        while ($row = mysqli_fetch_assoc($result)) {

                            echo '<div class="row mb-1 bg-white ">';

                            if ($row['ctlog_img'] != null) {
                                echo '<div class="col-3"><img class="img-fluid" src="img/menu/' . $row['ctlog_img'] . '" alt="Image Unavailable"></div>';
                            } else {
                                echo '<div class="col-3"><img class="img-fluid" src="https://dummyimage.com/640x360/f0f0f0/aaa" alt="Image Unavailable"></div>';
                            }

                            echo '<div class="col-7 text-capitalize">' . $row['ctlog_nme'] .
                                '<br><small class="text-muted">' . $row['ctlog_desc'] . '</small></div>';
                            echo '<div class="col-2 text-muted font-italic"><small >' . $row['ordr_stat'] . '</small>
							<br><small class="text-muted">' . $row['ordr_qty'] . ' Order(s)</small></div>';
                            echo '</div>';
                        }
                    } else {
                        echo "<p class=''> No history available yet.</p>";
                    }
                    ?>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {

            var url_string = window.location.href;
            var url = new URL(url_string);
            var action = url.searchParams.get("act");

            if (action === 'update') {
                $("#update_display").show();
                $("#profile_display").hide();

            }

        });
    </script>

    <script src="bootstrap/js/app.js"></script>

</body>

</html>