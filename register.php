<!DOCTYPE html>
<html>
<head>
    <title>Đăng ký</title>
    <link rel="stylesheet" type="text/css" href="register.css">
</head>
<body>
    <h2>Đăng ký</h2>
    <form method="POST" action="register.php">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>
        <label for="full_name">Họ tên:</label>
        <input type="text" id="full_name" name="full_name" required><br><br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="phone">Số điện thoại:</label>
        <input type="text" id="phone" name="phone" required><br><br>
        <input type="submit" value="Đăng ký">
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kết nối đến cơ sở dữ liệu MySQL
    $conn = new mysqli('localhost', 'username', 'password', 'users');

    // Lấy dữ liệu từ form đăng ký
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Truy vấn cơ sở dữ liệu để kiểm tra xem tên đăng nhập đã tồn tại chưa
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($query);

    if ($result->num_rows === 0) {
        // Thêm người dùng mới vào cơ sở dữ liệu
        $query = "INSERT INTO users (username, password, full_name, email, phone) VALUES ('$username', '$password', '$full_name', '$email', '$phone')";
        $conn->query($query);

        // Điều hướng đến trang đăng nhập
        header('Location: index.php');
    } else {
        // Tên đăng nhập đã tồn tại, hiển thị thông báo lỗi
        echo "Tên đăng nhập đã tồn tại!";
    }

    $conn->close();
}
?>
