<?php
session_start();

// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header('Location: login.php'); // Điều hướng người dùng đến trang đăng nhập nếu chưa đăng nhập hoặc không có quyền truy cập
    exit();
}

// Xử lý các thao tác thêm, sửa đổi và xóa thông tin sinh viên
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Kiểm tra và xử lý các yêu cầu thêm, sửa đổi và xóa dữ liệu
    // Code xử lý yêu cầu của bạn ở đây
    // Ví dụ:
    if (isset($_POST['add_student'])) {
        // Thêm sinh viên vào cơ sở dữ liệu
        // Code xử lý thêm sinh viên ở đây
    } elseif (isset($_POST['edit_student'])) {
        // Sửa đổi thông tin sinh viên trong cơ sở dữ liệu
        // Code xử lý sửa đổi thông tin sinh viên ở đây
    } elseif (isset($_POST['delete_student'])) {
        // Xóa sinh viên khỏi cơ sở dữ liệu
        // Code xử lý xóa sinh viên ở đây
    }
}

// Hiển thị giao diện người dùng
?>

<!DOCTYPE html>
<html>
<head>
    <title>Teacher Panel</title>
</head>
<body>
    <h1>Teacher Panel</h1>

    <h2>Welcome, <?php echo $_SESSION['username']; ?></h2>

    <!-- Form thêm sinh viên -->
    <h3>Add Student</h3>
    <form method="post">
        <!-- Các trường thông tin sinh viên -->
        <!-- Code HTML cho các trường thông tin sinh viên ở đây -->

        <input type="submit" name="add_student" value="Add Student">
    </form>

    <!-- Form sửa thông tin sinh viên -->
    <h3>Edit Student</h3>
    <form method="post">
        <!-- Các trường thông tin sinh viên -->
        <!-- Code HTML cho các trường thông tin sinh viên ở đây -->

        <input type="submit" name="edit_student" value="Edit Student">
    </form>

    <!-- Form xóa sinh viên -->
    <h3>Delete Student</h3>
    <form method="post">
        <!-- Các trường thông tin sinh viên -->
        <!-- Code HTML cho các trường thông tin sinh viên ở đây -->

        <input type="submit" name="delete_student" value="Delete Student">
    </form>
</body>
</html>
