<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Trang chủ</title>
    <link rel="stylesheet" type="text/css" href="index.css">
</head>
<body>
    <h2>Chào mừng đến mới trang chủ</h2>
    <form method="POST" action="login.php">
        <label for="username">Tên đăng nhập:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Mật khẩu:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Đăng nhập">
    </form>
    <br>
    <a href="register.php">Đăng ký</a>
</body>
</html>
