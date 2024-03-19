<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #90EE90;
            text-align: center;

        }

        form {
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 15px;
            width: 300px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        label {
            display: block;
            margin-bottom: 10px;
            text-align: left;
            font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border-radius: 5px;
        }

        button {
            margin: 10px;
            background-color: #2E8B57;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out;
        }

        button:hover {
            transform: scale(1.02);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #d9534f;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
            border: 1px solid #007bff;
            border-radius: 15px;
            padding: 7px 10px;
            display: inline-block;
            width: 210px;
            text-align: center;
            margin-bottom: 10px;
            background-color: #FFF8DC;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease-in-out;
        }

        a:hover {
            transform: scale(1.02);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <form action="login-check.php" method="POST">
        <h1>ĐĂNG NHẬP</h1>
        <div>
            <label>USERNAME:</label>
            <input type="text" name="username" required>
        </div>
        <div>
            <label>PASSWORD:</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">Đăng nhập</button>
        <button type="reset">Làm mới</button>
    </form>

    <a href="../User/register.php">Bạn chưa có tài khoản? Đăng kí ngay !</a>

    <?php
    if (isset($_SESSION['login_result'])) {
        $result = $_SESSION['login_result'];

        if (!empty($result)) {
            echo "<h2>CHÀO MỪNG BẠN ĐẾN VỚI TRANG WEB CỦA CHÚNG TÔI!</h2><br>";
            echo "<a href='../Client/Client.php'>Vẽ đồ thị</a><br>";
            echo "<a href='../Client/File.php'>Gửi file xử lý đồ thị</a><br>";
        } else {
            echo "<h2>Đăng nhập không thành công!</h2>";
        }

        unset($_SESSION['login_result']);
    }
    ?>
</body>

</html>