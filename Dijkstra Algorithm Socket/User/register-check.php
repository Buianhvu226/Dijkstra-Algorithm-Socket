<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["username_reg"];
    $pass = $_POST["password_reg"];

    $result = accept($name, $pass);

    if ($result === true) {
        $_SESSION['register_result'] = true;
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['register_result'] = false;
        $_SESSION['register_error'] = $result;
        header("Location: register.php");
        exit();
    }
}

function accept($name, $pass)
{
    $link = mysqli_connect("localhost", "root", "") or die('Không thể kết nối đến cơ sở dữ liệu');
    mysqli_select_db($link, "pbl4");

    // Kiểm tra xem tên người dùng đã tồn tại trong cơ sở dữ liệu chưa
    $check_query = "SELECT username FROM users WHERE username = ?";
    $check_stmt = mysqli_prepare($link, $check_query);

    if ($check_stmt) {
        mysqli_stmt_bind_param($check_stmt, "s", $name);
        mysqli_stmt_execute($check_stmt);
        mysqli_stmt_store_result($check_stmt);

        if (mysqli_stmt_num_rows($check_stmt) > 0) {
            mysqli_stmt_close($check_stmt);
            mysqli_close($link);
            return "Tên người dùng đã tồn tại !";
        }

        mysqli_stmt_close($check_stmt);
    } else {
        mysqli_close($link);
        return "Lỗi trong việc kiểm tra tên người dùng: " . mysqli_error($link);
    }

    // Nếu không có tên người dùng nào trùng, tiến hành chèn dữ liệu mới
    $sql = "INSERT INTO users(username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ss", $name, $pass);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        mysqli_close($link);
        return true; // Đăng ký thành công
    } else {
        mysqli_close($link);
        return "Lỗi trong việc chèn dữ liệu: " . mysqli_error($link);
    }
}
?>