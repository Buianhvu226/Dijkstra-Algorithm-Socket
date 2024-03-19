<!DOCTYPE html>
<html>
<head>
    <title>Thông báo Client kết nối</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #F0FFF0;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #333;
        }
        .client-info {
            font-size: 20px;
            margin-top: 20px;
        }
        .client-number {
            color: #007bff;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Thông báo Client kết nối</h1>
        <div class="client-info">
            <?php
            echo "Thêm một Client được kết nối! Client <span class='client-number'>$clientNumber</span>";
            ?>
        </div>
    </div>
</body>
</html>
