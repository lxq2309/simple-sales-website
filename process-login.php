<?php
require_once 'config.php';
require_once 'connection.php';

session_start();

if (empty ($_POST['email']) || empty ($_POST['password'])) {
    $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
    header('Location: register.php');
    exit;
}

$email = addslashes($_POST['email']);
$password = addslashes($_POST['password']);

// login
$sql = "SELECT * FROM customers WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) != 1) {
    $_SESSION['error'] = 'Tài khoản hoặc mật khẩu không chính xác';
    header('Location: login.php');
    exit;
} else {
    $customer = mysqli_fetch_assoc($result);
    session_start();
    $_SESSION['customer_id'] = $customer['customer_id'];
    $_SESSION['customer_name'] = $customer['name'];
    $_SESSION['success'] = 'Đăng nhập thành công!';
    header('Location: index.php');
    exit;
}
