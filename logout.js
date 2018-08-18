function logout() {
    var logout = localStorage.removeItem('token');

    alert('Logout successfully');
    window.location.href = "login.php";
}