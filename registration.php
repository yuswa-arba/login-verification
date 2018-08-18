<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="pages/Assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="col-md-12">
                <div class="form-group row">
                    <div class="col-md-6 text-lg-left action-page" style="margin-top: 20px">
                        <a type="button" hidden id="home" href="index.php" class="btn btn-info">Home</a>
                        <a type="button" hidden id="setting" href="setting.php" class="btn btn-info">Setting</a>
                    </div>
                    <div class="col-md-6 text-lg-right" style="margin-top: 20px">
                        <a type="button" hidden id="login" href="login.php" class="btn btn-info">Login</a>
                        <a type="button" hidden id="register" href="registration.php" class="btn btn-info left">Register</a>
                        <button type="button" hidden id="logout" class="btn btn-info left">Logout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="col-md-12">&nbsp;</div>
            <div class="card">
                <div class="card-header">Registration</div>
                <form method="post">
                    <div class="col-md-12">&nbsp;</div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="username" class="col-md-3 col-form-label text-lg-right">Username</label>
                            <div class="col-md-9">
                                <input id="username" type="text" class="form-control input-height" name="username"
                                       value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="email" class="col-md-3 col-form-label text-lg-right">E-mail</label>
                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control input-height" name="email" value=""
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="phone" class="col-md-3 col-form-label text-lg-right">Phone</label>
                            <div class="col-md-9">
                                <input id="phone" type="text" class="form-control input-height" name="phone" value=""
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label text-lg-right">Password</label>
                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control input-height" name="password"
                                       value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="confirm-password" class="col-md-3 col-form-label text-lg-right">Confirm
                                Password</label>
                            <div class="col-md-9">
                                <input id="confirm-password" type="password" class="form-control input-height"
                                       name="confirm-password" value="" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-3">
                            </div>
                            <div class="col-md-9 text-lg-right">
                                <button type="button" id="registration" class="btn btn-info">Registration</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="pages/Assets/jquery/jquery-1.11.1.min.js"></script>
<script type="application/javascript" src="pages/Assets/bootstrap/js/bootstrap.min.js"></script>
<script type="application/javascript" src="pages/Assets/jquery-ui/jquery-ui.min.js"></script>
<script>
    $(document).ready(function () {
        if (localStorage.getItem('token') == null) {
            $('#login').attr('hidden', false);
            $('#register').attr('hidden', false);
            $('#home').attr('hidden', true);
            $('#setting').attr('hidden', true);
            $('#logout').attr('hidden', true);
        } else {
            window.location.href = 'index.php';
        }
    });
    $('#registration').click(function () {

        var password = $('#password').val();
        var confirmPassword = $('#confirm-password').val();

        if (confirmPassword == password) {
            $.ajax({
                type: "post",
                url: "pages/Logic/registration.php",
                data: {
                    action: 'registration',
                    username: $('#username').val(),
                    email: $('#email').val(),
                    phone: $('#phone').val(),
                    password: password
                },
                dataType: "json",
                success: function (data) {

                    if (!data.isFailed) {
                        alert(data.message);
                        window.location.href = "login.php"
                    } else {
                        alert(data.message);
//                    window.location.href = 'login.php'
                    }
                }
            });
        } else {
            alert('password and confirm password is not the same');
        }
    })
</script>
</body>
</html>