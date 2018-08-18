<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8"/>
    <meta charset="utf-8">
    <title>Setting</title>
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
                    <div class="card-header">Setting</div>
                    <form method="post">
                        <div class="col-md-12">
                            &nbsp;
                            <input type="hidden" id="userId" value="">
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="verification" class="col-md-3 col-form-label text-lg-right">Verification
                                    2</label>
                                <div class="col-md-9">
                                    <select id="verification" class="form-control input-height" name="verification"
                                            required>
                                        <option value="0">False</option>
                                        <option value="1">True</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="verify-access" class="col-md-3 col-form-label text-lg-right">Verify
                                    Access</label>
                                <div class="col-md-9">
                                    <select id="verify-access" class="form-control input-height" name="verify-access"
                                            required>
                                        <option value="1">SMS</option>
                                        <option value="2">Email</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="verify-access" class="col-md-3 col-form-label text-lg-right">Phone</label>
                                <div class="col-md-9">
                                    <input type="text" id="phone" class="form-control input-height" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group row">
                                <div class="col-md-3">
                                </div>
                                <div class="col-md-9 text-lg-right">
                                    <button type="button" id="save" class="btn btn-info">Save</button>
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

                $.ajax({
                    type: 'POST',
                    url: "pages/Logic/setting.php",
                    data: {action: "getUser", accessToken: localStorage.getItem('token')},
                    dataType: "json",
                    success: function (data) {

                        console.log(data);
                        if (!data.isFailed) {
                            $('#userId').val(data.result.id);
                            $('#verification').val(data.result.verification_2);
                            $('#verify-access').val(data.result.access_verify);
                            $('#phone').val(data.result.phone);
                        } else {
                            console.log(data);
                        }
                    }
                });
            }
        });
        $('#logout').click(function () {
            logout();
        });
        $('#save').click(function () {

            var verification = $('#verification').val();
            var verifyAccess = $('#verify-access').val();
            var phone = $('#phone').val();
            var userId = $('#userId').val();

            $.ajax({
                type: "post",
                url: "pages/Logic/setting.php",
                data: {
                    action: 'setting',
                    userId: userId,
                    verification: verification,
                    verifyAccess: verifyAccess,
                    phone: phone
                },
                dataType: "json",
                success: function (data) {
                    if (!data.isFailed) {
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