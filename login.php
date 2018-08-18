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
                    <div class="card-header">Login</div>
                    <form method="post">
                        <div class="col-md-12">&nbsp;</div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="email" class="col-md-3 col-form-label text-lg-right">E-mail</label>
                                <div class="col-md-9">
                                    <input id="email" type="email" class="form-control input-height" name="email"
                                           value=""
                                           required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="password" class="col-md-3 col-form-label text-lg-right">Password</label>
                                <div class="col-md-9">
                                    <input id="password" type="password" class="form-control input-height"
                                           name="password"
                                           value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-9 text-lg-right">
                                    <button type="button" id="loggedIn" class="btn btn-info">Login</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
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
    $('#loggedIn').click(function () {

        var email = $('#email').val();
        var password = $('#password').val();

        if (email != "" && password != "") {

            $.ajax({
                type: "post",
                url: "pages/Logic/login.php",
                data: {
                    action: 'login',
                    email: email,
                    password: password
                },
                dataType: "json",
                success: function (data) {

                    if (!data.isFailed) {
                        if (!data.withVerify) {
                            localStorage.setItem('token', data.result.token);
                            alert(data.message);
                            window.location.href = "index.php";
                        } else {
                            alert(data.message);
                            window.location.href = "verifyCode.php?token=" + data.result.token;
                        }
                    } else {
                        alert(data.message)
                    }
                }
            });
        } else {
            alert("Email and password can't empty")
        }
    })
</script>
</body>
</html>