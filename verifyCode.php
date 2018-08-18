<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta charset="utf-8">
    <title>Verification Code</title>
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
                    <div class="card-header">Verification Code</div>
                    <form method="post">
                        <div class="col-md-12">
                            &nbsp;
                            <input type="hidden" id="token" value="<?= isset($_GET['token']) ? $_GET['token'] : ''; ?>">
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="verifyCode" class="col-md-3 col-form-label text-lg-right">Verification
                                    Code</label>
                                <div class="col-md-9">
                                    <input id="verifyCode" type="text" class="form-control input-height"
                                           name="verifyCode"
                                           value="" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-9 text-lg-right">
                                    <button type="button" id="verify" class="btn btn-info">Verify</button>
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
    $('#verify').click(function () {

        var token = $('#token').val();
        var verifyCode = $('#verifyCode').val();

        $.ajax({
            type: "post",
            url: "pages/Logic/verification/verifyLogin.php",
            data: {
                action: 'verifyCode',
                verifyToken: token,
                verification: verifyCode
            },
            dataType: "json",
            success: function (data) {

                if (!data.isFailed) {
                    localStorage.setItem('token', data.result.token);
                    alert(data.message);
                    window.location.href = "index.php";
                } else {
                    alert(data.message);
                }
            }
        });
    })
</script>
</body>
</html>