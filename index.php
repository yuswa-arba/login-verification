<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta charset="utf-8">
    <title>Home</title>
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
                        <a type="button" hidden id="register" href="registration.php"
                           class="btn btn-info left">Register</a>
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
                    <div class="card-header">Home</div>
                    <form method="post">
                        <div class="col-md-12">
                        </div>
                        <div class="col-md-12" style="margin-top: 10px; margin-bottom: 10px;">
                            Anda Berhasil login!!!
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
<script type="application/javascript" src="logout.js"></script>
<script type="application/javascript" src="checkUser.js"></script>
<script>
    $(document).ready(function () {
        if (localStorage.getItem('token') == null) {
            window.location.href = 'login.php';
        } else {
            checkLogin();

            $('#login').attr('hidden', true);
            $('#register').attr('hidden', true);
            $('#home').attr('hidden', false);
            $('#setting').attr('hidden', false);
            $('#logout').attr('hidden', false);
        }
    });
    $('#logout').click(function () {
        logout();
    });
</script>
</body>
</html>