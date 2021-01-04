$(document).ready(function () {

    // Fetch URL Parameter
    var url_string = window.location.href;
    var url = new URL(url_string);
    var action = url.searchParams.get("act");
    var filter = url.searchParams.get("q_filter");
    var errors = { "usr": "0", "pwd": "0" };


    switch (action) {
        case "login":
            $('#modalLoginForm').modal('show');
            break;
        case "success":
            $('#alert').html('<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                '<strong>Success!</strong>  Your order has been place and please wait patiently, thank you.' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>');
            break;
        case "error":
            $('#alert').html('<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                '<strong>Error!</strong> Please wait current order to be delivered before placing a new order, thank you.' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>');
            break;
        case "cancel":
            $('#alert').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                '<strong>Payment failed!</strong>  Payment has been canceled.' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>');
            break;
        case "not_login":
            $('#alert').html('<div class="alert alert-warning alert-dismissible fade show" role="alert">' +
                '<strong>Order failed!</strong>  Please login first to place an order.' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '</div>');
            break;
        default:
            break;
    }


    // Search Ajax
    $('#search_query').on('keyup', function () {

        var s_data = this.value;
        console.log(s_data);
        console.log(filter);

        $.ajax({
            type: "POST",
            url: 'action.php',
            data: { data: 's_query', s_data: s_data, q_filter: filter },
            dataType: 'json',
            success: function (data) {
                console.log(data);

                if (data == 'none') {

                    $('#display_area').html('<div class="col"><h3 class="text-center text-light p-5">No result.</h3></div>');

                } else {
                    $('#display_area').html('');

                    for (var i = 0; i < data.length; i++) {


                        if (data[i].ctlog_img != null) {

                            var imgsrc = '<img class="card-img-top" src="img/menu/' + data[i].ctlog_img + '" alt="Card image cap">';

                        } else {

                            var imgsrc = '<img class="card-img-top" src="https://dummyimage.com/640x360/f0f0f0/aaa" alt="Card image cap">';
                        }

                        $('#display_area').append('<div class="card text-right" style="width: 18rem;">' +
                            imgsrc +
                            '<div class="card-body">' +
                            '<h5 class="card-title text-capitalize">' + data[i].ctlog_nme + '</h5>' +
                            '<p class="card-text text-muted">' + data[i].ctlog_desc + '</p>' +
                            '<p class="card-text text-capitalize">' + data[i].ctlog_shp + "'s Shop</p>" +
                            '</div>' +
                            '<div class="card-footer text-right">' +
                            '<h5 class="card-text float-left text-success">RM ' + data[i].ctlog_prc + '</h5>' +
                            '<a href="browse?act=add&id=' + data[i].ctlog_id + '" class="btn btn-success">Add to cart</a>' +
                            '</div>' +
                            '</div>');

                    }
                }
            }

        });

    });

    // Compare password 
    $('#pwd, #c_pwd').on('keyup', function () {

        if ($('#pwd').val() != $('#c_pwd').val()) {

            $('#c_pwd').addClass("border border-danger");

        } else {

            $('#c_pwd').removeClass("border border-danger");
            errors['pwd'] = '0';

        }

    });

    // Compare shop password 
    $('#shop_password, #shop_confirm_password').on('keyup', function () {

        if ($('#shop_password').val() != $('#shop_confirm_password').val()) {

            $('#shop_confirm_password').addClass("border border-danger");

        } else {

            $('#shop_confirm_password').removeClass("border border-danger");
            errors['pwd'] = '0';

        }

    });

    // Check username availability Ajax
    $('#usr').on('keyup', function () {

        var usrname = this.value;

        $.ajax({
            type: "POST",
            url: 'action.php',
            data: { data: 'chk_usr', temp_usr: usrname },
            success: function (data) {

                if (data != 'null' || usrname.length < 4) {

                    $('#usr').addClass("border border-danger");
                    errors['usr'] = '1';

                } else {

                    $('#usr').removeClass("border border-danger");
                    errors['usr'] = '0';

                }
            }

        });

    });

    // Check shop username availability Ajax
    $('#shop_username').on('keyup', function () {

        var usrname = this.value;

        $.ajax({
            type: "POST",
            url: 'action.php',
            data: { data: 'chk_usr', temp_usr: usrname },
            success: function (data) {

                if (data != 'null' || usrname.length < 4) {

                    $('#shop_username').addClass("border border-danger");
                    errors['usr'] = '1';

                } else {

                    $('#shop_username').removeClass("border border-danger");
                    errors['usr'] = '0';

                }
            }

        });

    });

    // Create account processing Ajax
    $('#signup_form').on('submit', function (e) {

        e.preventDefault();

        var formData = new FormData(this);

        if (errors['pwd'] !== '1' || errors['usr'] !== '1') {

            $.ajax({
                url: 'action.php',
                type: 'post',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

                    if (data == 'true') {
                        window.location.replace('index');

                    }
                }
            });

        }

    });

    // Create account processing Ajax
    $('#vendor_form').on('submit', function (e) {

        e.preventDefault();

        var formData = new FormData(this);

        if (errors['pwd'] !== '1' || errors['usr'] !== '1') {

            $.ajax({
                url: 'action.php',
                type: 'post',
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {

                    if (data == 'true') {

                        window.location.replace('index');

                    }


                }
            });

        }

    });

    // Login authorization Ajax
    $('#login_form').on('submit', function (e) {

        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
            url: 'action.php',
            type: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (html) {
                console.log(html);
                if (html == 'true') {

                    window.location.replace('index');

                }

            }
        });

    });

    // Update credientials
    $('#update_form').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            url: 'action.php',
            type: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (html) {

                if (html == 'true') {
                    window.location.replace('profile?not=success');
                }
            }
        });

    });


});
