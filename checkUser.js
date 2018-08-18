function checkLogin() {
    $.ajax({
        type: "POST",
        url: "pages/Logic/login.php",
        data: {
            action: "checkLogin",
            accessToken: localStorage.getItem("token")
        },
        dataType: "json",
        success: function (data) {
            if (data.isFailed) {
                localStorage.removeItem('token');
                alert(data.message);
                window.location.href = "login.php";
            }
        }
    });
}