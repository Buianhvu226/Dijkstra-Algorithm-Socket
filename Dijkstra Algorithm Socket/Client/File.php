<?php
session_start();
if (isset($_SESSION['username'])) {
    $name = $_SESSION['username'];
    echo
        '<div style="text-align: right; font-family: Arial, sans-serif; margin-top: 20px; margin-right: 20px;">
            <span style="color: #333; font-weight: bold;">Xin chào</span>, 
            <span style="color: #45a049; font-style: italic; font-size: 22px">' . $name . '</span>
            <form action="../User/logout.php" method="post" style="display: inline-block; margin-left: 10px;"> 
                <input type="submit" value="Đăng xuất" style="padding: 8px 15px; background-color: #5091C7; color: white; border: none; cursor: pointer; border-radius: 4px;"> 
            </form>
        </div>';
} else {
    header("Location: ../User/login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Upload File to Server</title>
    <link rel="stylesheet" href="../Client.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #F0FFF0;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }

        a {
            text-decoration: none;
            color: #4caf50;
            font-weight: bold;
            border: 1px solid #4caf50;
            border-radius: 15px;
            padding: 7px 10px;
            display: inline-block;
            width: 100px;
            text-align: center;
            margin-bottom: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Nhập File để xử lý</h1>
        <form action="upload.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="beginVertex">Nhập điểm bắt đầu:</label>
                <input type="text" name="beginVertex" id="beginVertex" placeholder="Nhập điểm bắt đầu">
            </div>
            <div class="form-group">
                <label for="fileToUpload">Chọn file để tải lên:</label>
                <input type="file" name="fileToUpload" id="fileToUpload">
            </div>
            <div class="form-group">
                <input type="submit" value="Nhập File" name="submit">
            </div>
        </form>

        <a href="javascript:history.go(-1)">Quay lại</a>

    </div>
</body>

</html>