<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Kí </title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #87CEFA;
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
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            margin: 10px;
            width: 80px;
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
    <form action="register-check.php" method="POST">
        <h1>ĐĂNG KÍ</h1>
        <div>
            <label>USERNAME:</label>
            <input type="text" name="username_reg" required>
        </div>
        <div>
            <label>PASSWORD:</label>
            <input type="password" name="password_reg" required>
        </div>
        <button type="submit">Đăng kí</button>
        <button type="reset">Làm mới</button>
    </form>

    <a href="../User/login.php">Quay lại</a>

    <?php
    if (isset($_SESSION['register_result'])) {
        $result = $_SESSION['register_result'];

        if (!empty($result)) {
            echo "<h2>Đăng kí thành công!</h2><br>";
        } else {
            echo "<h2>Đăng kí không thành công!</h2>";
        }

        unset($_SESSION['register_result']);
    }
    ?>
</body>

</html>