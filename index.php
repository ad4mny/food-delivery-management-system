<?php
session_start();

if (isset($_SESSION["sess_id"])) {

    if ($_SESSION["sess_status"] == "admin") {
        header('location: admin/pnl_user');
    } else if ($_SESSION["sess_status"] == "shop") {
        header('location: shop/pnl_order');
    } else {
        header('location: home');
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
    <!-- <script src="bootstrap/js/popper.min.js"></script> -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <style type="text/css">
        .masthead {
            height: 100vh;
            min-height: 500px;
            background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://source.unsplash.com/-YHSwy6uqvk/1920x1080');
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

            </ul>
            <div class="form-inline my-2 my-lg-0">
                <a href="" class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#modalLoginForm">Login</a>
            </div>
    </nav>

    <!-- Content -->
    <!-- Full Page Image Header with Vertically Centered Content -->
    <header class="masthead">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12 text-center text-white">
                    <h1 class="font-weight-light">Food Ordering System</h1>
                    <p class="lead">A great way to fill your appetite </p>
                </div>
            </div>
        </div>
    </header>
    <!-- Page Content -->
    <section class="py-5">
        <div class="container">
            <h2 class="font-weight-light">Order Now</h2>
            <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repellendus ab nulla
                dolorum autem nisi officiis blanditiis voluptatem hic, assumenda aspernatur facere
                ipsam nemo ratione cumque magnam enim fugiat reprehenderit expedita.
            </p>
        </div>
    </section>

    <!-- Model Signup -->
    <div class="modal fade" id="modalSignupForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="action.php" method="post" id="signup_form">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Welcome to our family!</h4>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="usr" name="username" placeholder="Create a username">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="password" class="form-control" id="pwd" name="password" placeholder="Choose a password">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="password" class="form-control" id="c_pwd" name="confirm_password" placeholder="Confirm password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-map-marked-alt"></i></div>
                                    </div>
                                    <textarea class="form-control" rows="3" id="address" name="address" placeholder="Enter your address"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div class="col text-center">
                            <input type="hidden" name="signup" value="user">
                            <input type="submit" class="btn btn-default" value="Sign Up">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Model Vendor -->
    <div class="modal fade" id="modalVendorForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="action.php" method="post" id="vendor_form">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Become a vendor!</h4>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="Enter shop name">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" id="shop_username" name="shop_username" placeholder="Create a shop username">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="password" class="form-control" id="shop_password" name="shop_password" placeholder="Choose a password">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="password" class="form-control" id="shop_confirm_password" name="shop_confirm_password" placeholder="Confirm password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div class="col text-center">
                            <input type="hidden" name="signup" value="vendor">
                            <input type="submit" class="btn btn-default" value="Register">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Model Login -->
    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="action.php" method="post" id="login_form">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 font-weight-bold">Hello.</h4>
                    </div>
                    <div class="modal-body mx-3">
                        <div class="row">
                            <div class="col">
                                <label class="sr-only" for="inlineFormInputGroup1"></label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-user"></i></div>
                                    </div>
                                    <input type="text" class="form-control" name="username" placeholder="Username">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label class="sr-only" for="inlineFormInputGroup2"></label>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                    </div>
                                    <input type="password" class="form-control" name="password" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <small class="text-muted text-center"> Don't have an account? <a href="" class="text-primary" data-toggle="modal" data-dismiss="modal" data-target="#modalSignupForm">Sign up</a> now!</small><br>
                                <small class="text-muted text-center"> Become a vendor, register <a href="" class="text-primary" data-toggle="modal" data-dismiss="modal" data-target="#modalVendorForm">here</a>.</small>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <div class="col text-center">
                            <input type="hidden" name="login">
                            <input type="submit" class="btn btn-default" value="Login">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Script -->
    <script src="bootstrap/js/app.js"></script>
</body>

</html>